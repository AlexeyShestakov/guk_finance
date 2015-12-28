<?php

namespace Cebera;

class Conf
{
    const DB_NAME_GUK_FINANCE = 'guk_finance';

    public static function get()
    {
        $conf = \Cebera\Conf\Common::get();

        $conf['cache_lifetime'] = 60;

        $conf['return_false_if_no_route'] = true; // for local php server

        $conf['db'] = array(
            'guk_finance' => array(
        		'host' => 'localhost',
        		'db_name' => 'guk_finance',
        		'user' => 'root',
        		'pass' => '1'
    	    ),
        );

        return $conf;
    }
}
