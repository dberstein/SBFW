<?php

namespace Sfw;

class Version
{
    const VERSION = '0.1';

    static public function getVersion()
    {
        return 'v' . self::VERSION;
    }
}