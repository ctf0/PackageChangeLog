<?php

namespace ctf0\PackageChangeLog;

use Illuminate\Support\ServiceProvider;

class PackageChangeLogServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->commands([
            Commands\PackageChangeLogCommand::class,
        ]);
    }
}
