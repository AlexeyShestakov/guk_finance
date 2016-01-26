<?php

namespace Guk\GukPages;

class ControllerReports
{
    static public function reportsByVuzUrl(){
        return '/guk/reports/by_vuz';
    }

    public function reportsByVuzAction(){
        ob_start();
        \Guk\GukPages\Templates\ReportByVuzTemplate::render();
        $content = ob_get_clean();

        \Guk\GukPages\GukLayoutTemplate::render($content);
    }

}