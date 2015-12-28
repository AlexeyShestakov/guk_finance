<?php

namespace Guk\MainPage;

class ControllerMainPage
{
    public function entryPageAction(){
        echo \Cebera\Render\Render::callLocaltemplate("templates/entrypage.tpl.php");
    }

    public function mainPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/mainpage.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }
}