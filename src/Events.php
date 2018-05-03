<?php

namespace ctf0\PackageChangeLog;

use Composer\Script\Event;

/**
 * https://getcomposer.org/doc/articles/scripts.md#installer-events.
 */
class Events
{
    use Ops;

    /**
     * occurs after the "composer install" command has been executed.
     *
     * @param Event $event [description]
     *
     * @return [type] [description]
     */
    public static function postInstallCmd(Event $event)
    {
        return (new self())->buildLogs($event, 'install');
    }

    /**
     * occurs after the "composer update" command has been executed.
     *
     * @param Event $event [description]
     *
     * @return [type] [description]
     */
    public static function postUpdateCmd(Event $event)
    {
        return (new self())->buildLogs($event);
    }

    /**
     * clean old impl.
     *
     * @param Event $event [description]
     *
     * @return [type] [description]
     */
    public static function prePackageUpdate(Event $event)
    {
        $comp_file = __DIR__ . '/composer.json';
        $search    = 'App\\Providers\\EventServiceProvider::postAutoloadDump';
        $exist     = str_contains(file_get_contents($comp_file), $search);

        if ($exist) {
            $res  = json_decode(file_get_contents($comp_file), true);
            unset($res['scripts']['post-autoload-dump'][$search]);
            $json  = json_encode($res, JSON_PRETTY_PRINT);
            $final = str_replace('\/', '/', $json);
            file_put_contents($comp_file, $final);
        }
    }
}
