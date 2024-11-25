<?php

namespace ivenms\PackageChangeLog\Commands;

use Illuminate\Console\Command;
use ivenms\PackageChangeLog\Traits\Messages;

class PostInstall extends Command
{
    use Messages;

    protected $signature   = 'pcl:post-install';
    protected $description = 'package-changelog post-install';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->buildLogs('install', false);
    }
}
