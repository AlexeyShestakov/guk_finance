<?php

namespace Cebera\Conf;

class Common
{
    public static function get()
    {
        $conf = array();

        $conf['resources_version'] = '';

        $conf['cache_life_time'] = 60;

        return $conf;
    }
}
