<?php

namespace ctf0\PackageChangeLog\Commands;

use ctf0\PackageChangeLog\Ops;
use Illuminate\Console\Command;

class PCLCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'package:changelog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show Packages ChangeLog';

    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Foundation\PackageManifest
     */
    public function handle(Ops $packages)
    {
        $logs = $packages->changelogs();

        if (!$logs) {
            $this->comment(' - Nothing To Display');
        } else {
            foreach ($logs as $name => $v) {
                $this->alert("\"$name\" {$v['ver']} ChangeLog:");
                $this->info($v['log']);
            }
        }
    }
}
