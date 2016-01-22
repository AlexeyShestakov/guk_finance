<?php

namespace Cebera;

class BT
{
    static public function sanitizeTagContent($value){
        return htmlspecialchars($value);
    }

    static public function th($val){
        return '<th>' . self::sanitizeTagContent($val) . '</th>';
    }
}