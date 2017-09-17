<?php

namespace ctf0\PackageChangeLog;

class Ops
{
    use EventTrait;

    protected $vendorPath;

    public function __construct()
    {
        $this->vendorPath = base_path() . '/vendor';
    }

    /**
     * [buildLogs description].
     *
     * @param mixed $event
     *
     * @return [type] [description]
     */
    public function buildLogs($event)
    {
        $refPath  = '/composer/installed.json';
        $packages = [];

        if (file_exists($path = "{$this->vendorPath}{$refPath}")) {
            $packages = json_decode(file_get_contents($path), true);
        }

        $no_log = true;

        foreach ($packages as $one) {
            if (isset($one['extra']['changeLog'])) {
                $name           = $this->format($one['name']);
                $log_path       = $one['extra']['changeLog'];
                $version        = $one['version'];
                $package_path   = "$this->vendorPath/{$name}";
                $log_file       = glob("$package_path/$log_path/$version.*");

                if (!$log_file) {
                    continue;
                }

                $no_log      = false;
                $log_content = file_get_contents($log_file[0]);

                $this->alert("\"$name\" {$version} ChangeLog:", $event);
                $this->info($log_content, $event);

                // rename file so we dont display it again
                rename($log_file[0], "$package_path/$log_path/$version");
            }
        }

        if ($no_log) {
            $this->alert('No Available ChangeLogs At The Moment', $event);
        }
    }

    /**
     * Format the given package name.
     *
     * @param mixed $package
     */
    protected function format($package)
    {
        return str_replace("{$this->vendorPath}/", '', $package);
    }
}
