<?php

namespace ctf0\PackageChangeLog\Commands;

use Illuminate\Console\Command;
use ctf0\PackageChangeLog\Traits\Messages;

class PostInstall extends Command
{
    use Messages;

    protected $signature = 'pcl:post-install';
    protected $description = 'package-changelog post-install';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->buildLogs('install');
    }
}
