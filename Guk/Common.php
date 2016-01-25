<?php

namespace Guk;

class CommonConfig
{
    public static function get()
    {
        $conf = array();

        $conf['resources_version'] = '';

        $conf['cache_life_time'] = 60;

        return $conf;
    }
}
