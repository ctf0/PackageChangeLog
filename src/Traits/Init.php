<?php

namespace ivenms\PackageChangeLog\Traits;

use Illuminate\Support\Str;

trait Init
{
    protected function doStuff()
    {
        $comp_file  = \base_path() . '/composer.json';
        $json_data  = file_get_contents($comp_file);
        $list       = [
            'post-install'  => 'post-install-cmd',
            'post-update'   => 'post-update-cmd',
        ];

        $final = json_decode($json_data, true);

        foreach ($list as $cmnd => $event) {
            $search = "@php artisan pcl:$cmnd";

            if (!Str::contains($json_data, $search)) {
                isset($final['scripts'][$event])
                    ? array_push($final['scripts'][$event], $search)
                    : $final['scripts'][$event] = [$search];
            }
        }

        $json  = json_encode($final, JSON_PRETTY_PRINT);
        $final = str_replace('\/', '/', $json);

        return file_put_contents($comp_file, $final);
    }
}
