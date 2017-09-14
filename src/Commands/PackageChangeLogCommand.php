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

        foreach ($packages->changelogs() as $name => $log) {
            $this->alert("\"$name\" ChangeLog:");
            $this->info($log);
        }
    }
}
