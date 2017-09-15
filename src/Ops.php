<?php

namespace ctf0\PackageChangeLog;

use Exception;

class Ops
{
    use EventTrait;

    public $vendorPath;
    public $logManifest;
    public $refPath;

    public function __construct()
    {
        $this->logManifest  = storage_path() . '/logs/packagesLogs.php';
        $this->vendorPath   = base_path() . '/vendor';
        $this->refPath      = '/composer/installed.json';
    }

    /**
     * [changelogs description].
     *
     * @return [type] [description]
     */
    public function changelogs()
    {
        $this->build();

        return $this->buildLogs();
    }

    /**
     * [buildLogs description].
     *
     * @return [type] [description]
     */
    protected function buildLogs()
    {
        $list    = include $this->logManifest;
        $content = [];

        foreach ($list as $k => $v) {
            $package_path   = "$this->vendorPath/{$k}";
            $log_path       = $v['log_path'];
            $latest_version = $v['version'];
            $log_file       = glob("$package_path/$log_path/$latest_version.*");

            if (!$log_file) {
                continue;
            }

            $content[$k] = [
                'log' => file_get_contents($log_file[0]),
                'ver' => $latest_version,
            ];

            // rename file so we dont display it again
            rename($log_file[0], "$package_path/$log_path/$latest_version");
        }

        return $content;
    }

    /**
     * [build description].
     *
     * @return [type] [description]
     */
    protected function build()
    {
        $packages = [];

        if (file_exists($path = "{$this->vendorPath}{$this->refPath}")) {
            $packages = json_decode(file_get_contents($path), true);
        }

        $data = collect($packages)->map(function ($package) {
            if (isset($package['extra']['changeLog'])) {
                return [
                    $this->format($package['name']) => [
                        'log_path' => $package['extra']['changeLog'],
                        'version'  => $package['version'],
                    ],
                ];
            }
        })->filter()->all();

        $this->saveToDisk($data ? call_user_func_array('array_merge', $data) : []);
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

    /**
     * [saveToDisk description].
     *
     * @param [type] $manifest [description]
     *
     * @return [type] [description]
     */
    protected function saveToDisk($manifest)
    {
        if (!is_writable(dirname($this->logManifest))) {
            throw new Exception('The ' . dirname($this->logManifest) . ' directory must be present and writable.');
        }

        file_put_contents(
            $this->logManifest, "<?php\n\nreturn " . var_export($manifest, true) . ';'
        );
    }
}
