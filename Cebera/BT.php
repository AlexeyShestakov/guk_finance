<?php

namespace Cebera;

class BT
{
    static public function sanitizeTagContent($value){
        return htmlspecialchars($value);
    }

    static public function sanitizeUrl($url){
        //return filter_var(FILTER_SANITIZE_URL, $url);
        return $url; // TODO: sanitize
    }

    static public function sanitizeAttrValue($value){
        return htmlspecialchars($value);
    }

    static public function th($val){
        return '<th>' . self::sanitizeTagContent($val) . '</th>';
    }

    static public function td($val){
        return '<td>' . self::sanitizeTagContent($val) . '</td>';
    }

    static public function a($url, $text){
        return '<a href="' . self::sanitizeUrl($url) . '">' . self::sanitizeTagContent($text) . '</a>';
    }

    static public function beginTable(){
        return '<table class="table">';
    }

    static public function beginTr($classes){
        return '<tr class="' . self::sanitizeAttrValue($classes) . '">';
    }

    static public function endTable(){
        return '</table>';
    }

    static public function endTr(){
        return '</tr>';
    }
}