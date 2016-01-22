<?php

namespace Guk\GukPages;

class ControllerReports
{
    static public function reportsByVuzUrl(){
        return '/guk/reports/by_vuz';
    }

    public function reportsByVuzAction(){
        ob_start();
        \Guk\GukPages\templates\ReportByVuzTemplate::render();
        $content = ob_get_clean();

        \Guk\GukPages\templates\GukLayoutTemplate::render($content);
    }

}