<?php

namespace ctf0\PackageChangeLog;

use Illuminate\Support\ServiceProvider;

class PackageChangeLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (file_exists(base_path() . '/composer.json') &&
            !$this->app['cache']->store('file')->has('ct-pcl')
        ) {
            $this->autoReg();
        }
    }

    protected function autoReg()
    {
        /**
         * EventServiceProvider.php.
         *
         * @var [type]
         */
        $event_file = app_path() . '/Providers/EventServiceProvider.php';
        $search     = 'ctf0/package-changelog';

        if (!$this->checkExist($event_file, $search)) {
            $data =
<<<'EOT'

    /**
     * "ctf0/package-changelog".
     */
    public static function postAutoloadDump(\Composer\Script\Event $event)
    {
        if (class_exists('ctf0\\PackageChangeLog\\Ops')) {
            return \ctf0\PackageChangeLog\Ops::postAutoloadDump($event);
        }
    }
}
EOT;
            file_put_contents($event_file, preg_replace('/\}(.*?)$/', $data, file_get_contents($event_file)));
        }

        /**
         * composer.json.
         *
         * @var [type]
         */
        $comp_file = base_path() . '/composer.json';
        $search    = 'EventServiceProvider::postAutoloadDump';

        if (!$this->checkExist($comp_file, $search)) {
            $data = 'App\\Providers\\' . $search;
            $res  = json_decode(file_get_contents($comp_file), true);

            if ($res['scripts']['post-autoload-dump']) {
                array_push($res['scripts']['post-autoload-dump'], $data);
                $json  = json_encode($res, JSON_PRETTY_PRINT);
                $final = str_replace('\/', '/', $json);
                file_put_contents($comp_file, $final);
            }
        }

        // run check once
        $this->app['cache']->store('file')->rememberForever('ct-pcl', function () {
            return 'added';
        });
    }

    protected function checkExist($file, $search)
    {
        return str_contains(file_get_contents($file), $search);
    }
}
