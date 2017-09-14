<?php

namespace ctf0\PackageChangeLog;

use Exception;
use Illuminate\Filesystem\Filesystem;

class PackageChangeLog
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    public $files;

    /**
     * The vendor path.
     *
     * @var string
     */
    public $vendorPath;

    /**
     * The logTempPath path.
     *
     * @var string|null
     */
    public $logTempPath;

    /**
     * Create a new package manifest instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files        = $files;
        $this->logTempPath  = storage_path('logs/packagesLogs.php');
        $this->vendorPath   = base_path() . '/vendor';
    }

    /**
     * get packages ChangeLogs.
     *
     * @return [type] [description]
     */
    public function changelogs()
    {
        $list    = include $this->logTempPath;
        $content = [];

        foreach ($list as $k => $v) {
            $package_path   = "$this->vendorPath/{$k}";
            $log_path       = $v['log_path'];
            $latest_version = $v['version'];
            $log_file       = $this->files->glob("$package_path/$log_path/$latest_version.*");

            if (empty($log_file)) {
                continue;
            }

            if ($this->files->exists($log_file[0])) {
                $content[$k] = $this->files->get($log_file[0]);

                // rename file so we dont display it again
                $this->files->move($log_file[0], "$package_path/$log_path/$latest_version");
            }
        }

        return $content;
    }

    /**
     * Build the manifest and write it to disk.
     */
    public function build()
    {
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath . '/composer/installed.json')) {
            $packages = json_decode($this->files->get($path), true);
        }

        $data = collect($packages)->map(function ($package) {
            if (isset($package['extra']['laravel']['changeLog'])) {
                return [
                    $this->format($package['name']) => [
                        'log_path' => $package['extra']['laravel']['changeLog'],
                        'version'  => $package['version'],
                    ],
                ];
            }
        })->filter()->all();

        $this->write($data ? call_user_func_array('array_merge', $data) : []);
    }

    /**
     * Format the given package name.
     *
     * @param string $package
     *
     * @return string
     */
    protected function format($package)
    {
        return str_replace($this->vendorPath . '/', '', $package);
    }

    /**
     * Write the given manifest array to disk.
     *
     * @param array $manifest
     *
     * @throws \Exception
     */
    protected function write(array $manifest)
    {
        if (!is_writable(dirname($this->logTempPath))) {
            throw new Exception('The ' . dirname($this->logTempPath) . ' directory must be present and writable.');
        }

        $this->files->put(
            $this->logTempPath, "<?php\n\nreturn " . var_export($manifest, true) . ';'
        );
    }
}
