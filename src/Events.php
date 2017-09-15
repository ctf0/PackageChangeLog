<?php

namespace ctf0\PackageChangeLog;

use Composer\Script\Event;

class Events
{
    public static function postAutoloadDump(Event $event)
    {
        logger($event->getIO());
    }
}
