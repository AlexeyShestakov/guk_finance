<?php

namespace Guk\MainPage;

class ControllerMainPage
{
    public function mainPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/mainpage.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../layout.tpl.php", array('content' => $content));
    }
}