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

    static public function detailsForRequestAndFormRowAction($mode, $request_id, $row_id){
        $self_url = '/guk/reports/details_for_request_and_form_row/' . $request_id . '/' . $row_id;
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        $request_obj = \Guk\FinRequest::factory($request_id);
        $form_id = $request_obj->getFinFormId();

        echo '<table class="table table-bordered table-condensed">';
        echo '<thead><tr>';

        $detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormByWeight($form_id);
        foreach ($detail_column_ids_arr as $detail_column_id){
            $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);
            echo '<th class="text-center"><small>' . $detail_column_obj->getTitle() . '</small></th>';
        }

        echo '</thead>';

        $detail_row_ids_arr = \Guk\DetailRow::getDetailRowIdsArrForRequestAndFormRowById($request_id, $row_id);
        foreach ($detail_row_ids_arr as $detail_row_id){
            //$detail_row_obj = \Guk\DetailRow::factory($detail_row_id);

            $detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormByWeight($form_id);

            echo '<tr>';
            foreach ($detail_column_ids_arr as $detail_column_id) {
                //$detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);

                $detail_value = '';
                $detail_cell_obj = \Guk\DetailCell::getObjForRowAndCol($detail_row_id, $detail_column_id);
                if ($detail_cell_obj) {
                    $detail_value = $detail_cell_obj->getValue();
                }

                echo '<td><small>' . $detail_value . '</small></td>';
            }

            echo '</tr>';
        }

        echo '</table>';

    }

}