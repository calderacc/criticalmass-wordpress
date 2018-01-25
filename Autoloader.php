<?php

namespace Caldera\CriticalmassWordpress;

class Autoloader
{
    const PREFIX = 'Caldera\\CriticalmassWordpress\\';

    public function autoload($classname)
    {
        $prefixLength = strlen(self::PREFIX);

        if (strncmp(self::PREFIX, $classname, $prefixLength) !== 0) {
            return false;
        }

        $relativeClassname = substr($classname, $prefixLength);

        $filename = sprintf('%s/%s.php', __DIR__, str_replace('\\', '/', $relativeClassname));

        require_once $filename;

        return true;
    }
}
