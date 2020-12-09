<?php

namespace ctf0\PackageChangeLog\Commands;

use Illuminate\Console\Command;
use ctf0\PackageChangeLog\Traits\Messages;

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
