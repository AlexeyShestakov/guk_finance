<?php

namespace Guk\Pages\Reports;

use Cebera\BT;

class ControllerReports
{
    /*
    static public function reportsByVuzUrl(){
        return ;
    }
    */

    static public function reportsByVuzAction($mode){
        $self_url = '/guk/reports/by_vuz';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        BT::matchOperation(ReportByVuz2Template::OPERATION_EDIT_REQUEST_SUM, function() {
            $request_id = BT::getPostValue(ReportByVuz2Template::FIELD_REQUEST_ID);
            $row_id = BT::getPostValue(ReportByVuz2Template::FIELD_ROW_ID);
            $corrected_value = BT::getPostValue(ReportByVuz2Template::FIELD_CORRECTED_SUM);

            $request_obj = \Guk\FinRequest::factory($request_id);
            $request_obj->setCorrectedSumForRow($row_id, $corrected_value);
        });

        ob_start();
        \Guk\Pages\Reports\ReportByVuz2Template::render();
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

}