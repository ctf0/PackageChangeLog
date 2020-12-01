<?php

namespace ctf0\PackageChangeLog\Traits;

use Illuminate\Support\Str;

trait Init
{
    /* -------------------------------------------------------------------------- */
    /*                                     OPS                                    */
    /* -------------------------------------------------------------------------- */

    protected function postUpdate($comp_file)
    {
        $search = '@php artisan pcl:post-update';

        if (!$this->checkExist($comp_file, $search)) {
            $data = $search;
            $res = json_decode(file_get_contents($comp_file), true);

            if ($res['scripts']['post-autoload-dump']) {
                array_push($res['scripts']['post-autoload-dump'], $data);
                $json = json_encode($res, JSON_PRETTY_PRINT);
                $final = str_replace('\/', '/', $json);
                file_put_contents($comp_file, $final);
            }
        }
    }

    protected function postInstall($comp_file)
    {
        $search = '@php artisan pcl:post-install';

        if (!$this->checkExist($comp_file, $search)) {
            $res = json_decode(file_get_contents($comp_file), true);

            isset($res['scripts']['post-install-cmd'])
                ? array_push($res['scripts']['post-install-cmd'], $search)
                : $res['scripts']['post-install-cmd'] = [$search];

            $json = json_encode($res, JSON_PRETTY_PRINT);
            $final = str_replace('\/', '/', $json);
            file_put_contents($comp_file, $final);
        }
    }

    protected function preUninstall($comp_file)
    {
        $search = '@php artisan pcl:pre-uninstall';

        if (!$this->checkExist($comp_file, $search)) {
            $res = json_decode(file_get_contents($comp_file), true);

            isset($res['scripts']['pre-package-uninstall'])
                ? array_push($res['scripts']['pre-package-uninstall'], $search)
                : $res['scripts']['pre-package-uninstall'] = [$search];

            $json = json_encode($res, JSON_PRETTY_PRINT);
            $final = str_replace('\/', '/', $json);
            file_put_contents($comp_file, $final);
        }
    }

    /* -------------------------------------------------------------------------- */

    protected function checkExist($file, $search)
    {
        return Str::contains(file_get_contents($file), $search);
    }
}
