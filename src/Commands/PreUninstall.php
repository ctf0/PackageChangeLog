<?php

namespace ctf0\PackageChangeLog\Commands;

use Illuminate\Console\Command;
use ctf0\PackageChangeLog\Traits\Messages;

class PreUninstall extends Command
{
    use Messages;

    protected $signature   = 'pcl:pre-uninstall';
    protected $description = 'package-changelog pre-uninstall';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->buildLogs('uninstall', false);
    }
}
