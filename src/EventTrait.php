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
        (new self())->buildLogs($event);
        $event->getIO()->write('');
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
