<?php

namespace ctf0\PackageChangeLog\Commands;

use Illuminate\Console\Command;
use ctf0\PackageChangeLog\PackageChangeLog;

class PackageChangeLogCommand extends Command
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
    protected $description = 'show package changelog';

    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Foundation\PackageManifest
     */
    public function handle(PackageChangeLog $packages)
    {
        $packages->build();

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
