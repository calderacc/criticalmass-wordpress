<?php

namespace Caldera\CriticalmassWordpress\Util;

class TimeUtil
{
    public static function getHostTimezone()
    {
        try {
            $timezone = new \DateTimeZone(get_option('timezone_string'));

            return $timezone;
        } catch (\Exception $exception) {
            return new \DateTimeZone('UTC');
        }
    }
}
