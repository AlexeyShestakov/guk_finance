<?php

namespace Guk\GukPages;

class ControllerDFO
{

    static public function dfoUrl(){
        return '/guk/dfo';
    }

    public function dfoAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/dfo.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function dfoGenerateUrl(){
        return '/guk/dfo/generate';
    }

    public function dfoGenerateAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/dfo_generate.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

}