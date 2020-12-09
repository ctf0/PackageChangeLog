<?php

namespace ctf0\PackageChangeLog;

use ctf0\PackageChangeLog\Traits\Init;
use Illuminate\Support\ServiceProvider;

class PackageChangeLogServiceProvider extends ServiceProvider
{
    use Init;

    public function boot()
    {
        if (
            file_exists(\base_path() . '/composer.json') &&
            !$this->app['cache']->store('file')->has('ct-pcl')
        ) {
            $this->autoReg();
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                \ctf0\PackageChangeLog\Commands\PostInstall::class,
                \ctf0\PackageChangeLog\Commands\PreUninstall::class,
                \ctf0\PackageChangeLog\Commands\PostUpdate::class,
            ]);
        }
    }

    protected function autoReg()
    {
        $this->doStuff();

        // run check once
        $this->app['cache']->store('file')->rememberForever('ct-pcl', function () {
            return 'added';
        });
    }
}
