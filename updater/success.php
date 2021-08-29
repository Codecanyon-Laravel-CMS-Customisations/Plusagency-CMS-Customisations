<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 pt-5">    
                <div class="alert alert-success">
                    <strong>You have successfully updated to the latest version</strong>
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong>Upload Updated Files & Database Back to Live Server</strong>
                    </div>
                    <ul class="list-group list-group-flush">        
                        <li class="list-group-item">Delete 'updater' folder</li>
                        <li class="list-group-item">Compress & zip the Updated project files of localhost</li>
                        <li class="list-group-item">Delete the projects files from live server & upload the updated zip files of localhost there & unzip it</li>
                        <li class="list-group-item">Export the latest database SQL file from localhost</li>
                        <li class="list-group-item">Delete the previous tables of live server database & import the latest SQL file of localhost in live server database.</li>
                    </ul>
                    <div class="card-footer text-center">
                        <a class="btn btn-success" href="../">Go To Website</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>