<?php

namespace Guk;

class Helpers
{
    static public function replaceEmptyString($str){
        if (!$str){
            return 'пустое значение';
        }

        return $str;
    }
}