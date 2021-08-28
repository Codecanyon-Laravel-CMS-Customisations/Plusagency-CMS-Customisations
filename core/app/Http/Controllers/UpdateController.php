<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use App\BasicExtended;
use App\BasicExtra;
use App\Home;
use App\Language;
use App\Menu;
use App\PaymentGateway;
use Illuminate\Http\Request;
use Artisan;
use DB;

class UpdateController extends Controller
{
    public function version()
    {
        return view('updater.version');
    }

    public function recurse_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    @copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function upversion()
    {
        $assets = array(
            ['path' => 'assets/admin/js', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/admin/css', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/admin/img', 'type' => 'folder', 'action' => 'add'],
            ['path' => 'assets/admin/fonts', 'type' => 'folder', 'action' => 'replace'],

            ['path' => 'assets/front/css', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/front/js', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/front/fonts', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/front/img', 'type' => 'folder', 'action' => 'add'],

            ['path' => 'assets/lfm/js', 'type' => 'folder', 'action' => 'add'],
            ['path' => 'assets/lfm/css', 'type' => 'folder', 'action' => 'add'],
            ['path' => 'assets/lfm/img', 'type' => 'folder', 'action' => 'add'],
            ['path' => 'assets/lfm/files', 'type' => 'folder', 'action' => 'add'],

            ['path' => 'assets/user/css', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/user/js', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/user/fonts', 'type' => 'folder', 'action' => 'replace'],

            ['path' => 'core/config', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'core/database/migrations', 'type' => 'folder', 'action' => 'add'],
            ['path' => 'core/resources/views', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'core/routes/web.php', 'type' => 'file', 'action' => 'replace'],
            ['path' => 'core/app', 'type' => 'folder', 'action' => 'replace'],

            ['path' => 'version.json', 'type' => 'file', 'action' => 'replace'],
            ['path' => 'sw.js', 'type' => 'file', 'action' => 'replace'],

            ['path' => 'core/vendor/softon', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'core/vendor/unisharp', 'type' => 'folder', 'action' => 'replace']
        );

        foreach ($assets as $key => $asset) {
            // if updater need to replace files / folder (with/without content)
            if ($asset['action'] == 'replace') {
                if ($asset['type'] == 'file') {
                    @copy('updater/' . $asset["path"], $asset["path"]);
                }
                if ($asset['type'] == 'folder') {
                    @unlink($asset["path"]);
                    $this->recurse_copy('updater/' . $asset["path"], $asset["path"]);
                }
            }
            // if updater need to add files / folder (with/without content)
            elseif ($asset['action'] == 'add') {
                if ($asset['type'] == 'folder') {
                    @mkdir($asset["path"] . '/', 0775, true);
                    $this->recurse_copy('updater/' . $asset["path"], $asset["path"]);
                }
            }
        }


        $bes = BasicExtended::all();
        foreach($bes as $be) {
            $arr = explode("_", $be->theme_version, 2);
            $be->theme_version = $arr[0];
            $be->save();
        }

        $homes = Home::all();
        foreach($homes as $home) {
            $arr = explode("_", $home->theme, 2);
            $home->theme = $arr[0];
            $home->save();
        }


        $this->updateLanguage();

        Artisan::call('config:clear');
        // run migration files
        Artisan::call('migrate');

        Schema::dropIfExists('permalinks');
        DB::unprepared(file_get_contents('updater/permalinks.sql'));

        Schema::dropIfExists('email_templates');
        DB::unprepared(file_get_contents('updater/email_templates.sql'));

        // $this->delete_directory('updater');

        \Session::flash('success', 'Updated successfully');
        return redirect('updater/success.php');
    }

    function delete_directory($dirname)
    {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    $this->delete_directory($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }

    public function updateLanguage()
    {
        $langCodes = [];
        $languages = Language::all();
        foreach ($languages as $key => $language) {
            $langCodes[] = $language->code;
        }
        $langCodes[] = 'default';

        foreach ($langCodes as $key => $langCode) {
            // read language json file
            $data = file_get_contents('core/resources/lang/' . $langCode . '.json');

            // decode default json
            $json_arr = json_decode($data, true);


            // new keys
            $newKeywordsJson = file_get_contents('updater/language.json');
            $newKeywords = json_decode($newKeywordsJson, true);
            foreach ($newKeywords as $key => $newKeyword) {
                // # code...
                if (!array_key_exists($key, $json_arr)) {
                    $json_arr[$key] = $key;
                }
            }

            // push the new key-value pairs in language json files
            file_put_contents('core/resources/lang/' . $langCode . '.json', json_encode($json_arr));
        }
    }
}
