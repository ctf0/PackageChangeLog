<?php

namespace ivenms\PackageChangeLog;

use ivenms\PackageChangeLog\Traits\Init;
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
                \ivenms\PackageChangeLog\Commands\PostInstall::class,
                \ivenms\PackageChangeLog\Commands\PostUpdate::class,
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
