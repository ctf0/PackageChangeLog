<?php

namespace ctf0\PackageChangeLog;

trait Ops
{
    /**
     * [buildLogs description].
     *
     * @param mixed $event
     * @param mixed $type
     *
     * @return [type] [description]
     */
    public function buildLogs($event, $type = 'update')
    {
        $vendorPath = $event->getComposer()->getConfig()->get('vendor-dir');
        $refPath    = '/composer/installed.json';
        $packages   = [];

        if (file_exists($path = "{$vendorPath}{$refPath}")) {
            $packages = json_decode(file_get_contents($path), true);
        }

        $no_log = true;

        foreach ($packages as $one) {
            if (isset($one['extra']['changeLog'])) {
                $name           = $this->format($vendorPath, $one['name']);
                $log_path       = $one['extra']['changeLog'];
                $version        = $one['version'];
                $package_path   = "$vendorPath/{$name}";
                $log_file       = $type == 'install'
                    ? glob("$package_path/$log_path/install.*")
                    : glob("$package_path/$log_path/$version.*");

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

        $event->getIO()->write('');
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
    public function alert($string, $event)
    {
        $this->comment(str_repeat('*', strlen($string) + 12), $event);
        $this->comment('*     ' . $string . '     *', $event);
        $this->comment(str_repeat('*', strlen($string) + 12), $event);
    }

    public function comment($string, $event)
    {
        $this->line($string, 'comment', $event);
    }

    public function info($string, $event)
    {
        $this->line($string, 'info', $event);
    }

    public function line($string, $style, $event)
    {
        $event->getIO()->write("<$style>$string</$style>");
    }
}
