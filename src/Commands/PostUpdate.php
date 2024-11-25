<?php

namespace ivenms\PackageChangeLog\Commands;

use Illuminate\Console\Command;
use ivenms\PackageChangeLog\Traits\Messages;

class PostUpdate extends Command
{
    use Messages;

    protected $signature   = 'pcl:post-update';
    protected $description = 'package-changelog post-update';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->buildLogs();
    }
}
