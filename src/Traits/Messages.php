<?php

namespace ivenms\PackageChangeLog\Traits;

trait Messages
{
    /**
     * [buildLogs description].
     *
     * @param string|null $type
     * @param bool        $showEmptyLog
     *
     * @return [type] [description]
     */
    public function buildLogs($type = null, $showEmptyLog = true)
    {
        $vendorPath = \base_path('vendor');
        $refPath    = '/composer/installed.json';
        $packages   = [];

        if (file_exists($path = "{$vendorPath}{$refPath}")) {
            $installed = json_decode(file_get_contents($path), true);

            $packages = $installed['packages'] ?? $installed;
        }

        $no_log = true;

        foreach ($packages as $one) {
            if (isset($one['extra']['changeLog'])) {
                $name         = $this->format($vendorPath, $one['name']);
                $log_path     = $one['extra']['changeLog'];
                $version      = $one['version'];
                $package_path = "$vendorPath/{$name}";
                $log_file     = $type
                                    ? glob("$package_path/$log_path/$type.*")
                                    : glob("$package_path/$log_path/$version.*");

                if (!$log_file) {
                    continue;
                }

                $no_log      = false;
                $log_content = file_get_contents($log_file[0]);

                $this->header("\"$name\" {$version} ChangeLog:");
                $this->info($log_content);

                // rename file so we dont display it again
                rename($log_file[0], "$package_path/$log_path/$version");
            }
        }

        if ($no_log && $showEmptyLog) {
            $this->header('No Available ChangeLogs At The Moment');
        }

        $this->line('');
    }

    /**
     * Format the given package name.
     *
     * @param mixed $package
     * @param mixed $vendorPath
     */
    protected function format($vendorPath, $package)
    {
        return str_replace("{$vendorPath}/", '', $package);
    }

    /**
     * helpers.
     *
     * @param [type] $string [description]
     * @param [type] $event  [description]
     *
     * @return [type] [description]
     */
    public function header($string)
    {
        $this->comment(str_repeat('*', strlen($string) + 12));
        $this->comment('*     ' . $string . '     *');
        $this->comment(str_repeat('*', strlen($string) + 12));
    }
}
