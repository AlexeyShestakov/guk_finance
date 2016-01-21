<?php

namespace Guk\GukPages;

class ControllerReports
{
    static public function reportsByVuzUrl(){
        return '/guk/reports/by_vuz';
    }

    public function reportsByVuzAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/reports_by_vuz.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

}