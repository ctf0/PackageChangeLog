<?php

namespace ctf0\PackageChangeLog;

trait EventTrait
{
    /**
     * [postAutoloadDump description].
     *
     * @param Event $event [description]
     *
     * @return [type] [description]
     */
    public static function postAutoloadDump($event)
    {
        $ops  = new self();
        $logs = $ops->changelogs();

        if (!$logs) {
            static::alert('No Available ChangeLogs At The Moment', $event);
        } else {
            foreach ($logs as $name => $v) {
                static::alert("\"$name\" {$v['ver']} ChangeLog:", $event);
                static::info($v['log'], $event);
            }
        }
    }

    /**
     * helpers.
     *
     * @param [type] $string [description]
     * @param [type] $event  [description]
     *
     * @return [type] [description]
     */
    public static function alert($string, $event)
    {
        static::comment(str_repeat('*', strlen($string) + 12), $event);
        static::comment('*     ' . $string . '     *', $event);
        static::comment(str_repeat('*', strlen($string) + 12), $event);
    }

    public static function comment($string, $event)
    {
        static::line($string, 'comment', $event);
    }

    public static function info($string, $event)
    {
        static::line($string, 'info', $event);
    }

    public static function line($string, $style, $event)
    {
        return $event->getIO()->write("<$style>$string</$style>");
    }
}
