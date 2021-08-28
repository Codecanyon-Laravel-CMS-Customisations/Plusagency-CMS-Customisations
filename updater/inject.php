<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updater</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php
        // append web.php
        $appendThis = file_get_contents("web.php");
        $appendTo = fopen("../core/routes/web.php", "a");
        fwrite($appendTo, $appendThis);
        fclose($appendTo);

        // place UpdaterController.php
        @unlink('../core/app/Http/Controllers/UpdateController.php');
        @copy("UpdateController.php", '../core/app/Http/Controllers/UpdateController.php');
        @copy("core/app/Http/Helpers/Sections.php", '../core/app/Http/Helpers/Sections.php');
        @copy("core/app/Http/Kernel.php", '../core/app/Http/Kernel.php');

        // replace composer.json, composer.lock
        @unlink('../core/composer.json');
        @unlink('../core/composer.lock');
        @unlink('../version.json');
        @copy("core/composer.json", '../core/composer.json');
        @copy("core/composer.lock", '../core/composer.lock');
        @copy("version.json", '../version.json');
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 pt-5">    
                <div class="alert alert-success">
                    Updater codes has been injected
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong>Follow These Steps:</strong>
                    </div>
                    <ul class="list-group list-group-flush">     
                        <li class="list-group-item">
                            <strong class="text-danger">1.</strong> Download & install <a href="https://getcomposer.org/download/" target="_blank">Composer.exe</a>
                        </li>   
                        <li class="list-group-item">
                            <strong class="text-danger">2.</strong> Open command prompt into your <strong>project folder</strong>
                            <br>
                            <strong>Screenshot:</strong>
                            <br>
                            <img src="screenshots/project_folder.jpg" alt="" style="width: 100%;">
                        </li>
                        <li class="list-group-item">
                            <strong class="text-danger">3.</strong> Navigate to <strong>'core'</strong> folder writing <strong>'cd core'</strong> in command prompt
                            <br>
                            <strong>Screenshot:</strong>
                            <br>
                            <img src="screenshots/cd_core.jpg" alt="" style="width: 100%;">
                        </li>
                        <li class="list-group-item">
                            <strong class="text-danger">4.</strong> Run <strong>composer update</strong> in command prompt & wait patiently untill it is completed [It will take time].
                            <br>
                            <strong>Screenshot:</strong>
                            <br>
                            <img src="screenshots/composer-update.jpg" alt="" style="width: 100%;">
                        </li>
                    </ul>
                    <div class="card-footer text-center">
                        <a class="btn btn-success" href="../update/version">Update Database & Languages</a>
                        <p class="text-danger mb-0">After <strong>composer update</strong> is finished successfully</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>