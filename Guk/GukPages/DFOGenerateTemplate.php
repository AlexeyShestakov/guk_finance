<?php

namespace Guk\GukPages;

class DFOGenerateTemplate
{
    static public function render(){
        echo \Cebera\BT::h1_plain('Заявка в ДФО');
        echo '<div><button class="btn btn-defaul">Экспортировать в Excel</button></div>';
        echo '<div>&nbsp;</div>';

        $vuz_request_ids_arr = array();

        foreach ($_POST as $post_key => $post_value){
            $matches_arr = array();
            if (preg_match('@^request_(\d+)$@', $post_key, $matches_arr)){
                array_push($vuz_request_ids_arr, $matches_arr[1]);
            }
        }

        foreach ($vuz_request_ids_arr as $vuz_request_id){
            $vuz_request_obj = \Guk\FinRequest::factory($vuz_request_id);

            $form_id = $vuz_request_obj->getFinFormId();
            $form_obj = \Guk\FinForm::factory($form_id);

            $row_ids_arr = $form_obj->getRowIdsArrByWeight();
            $requested_sum_col_id = $form_obj->getRequestedSumColId();
            \OLOG\Helpers::assert($requested_sum_col_id);

            $vuz_id = $vuz_request_obj->getVuzId();
            $vuz_obj = \Guk\Vuz::factory($vuz_id);

            echo '<h3>Платеж для ВУЗа "' . $vuz_obj->getTitle() . '"</h3>';
            echo '<table class="table table-bordered">';
            echo '<tr>';
            echo '<thead>';
            echo '<th>КБК</th>';
            echo '<th>Сумма (тыс. руб.)</th>';
            echo '</thead>';
            echo '</tr>';

            foreach ($row_ids_arr as $form_row_id){
                $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($vuz_request_id, $form_row_id, $requested_sum_col_id);

                if ($request_cell_obj) {
                    $form_row_obj = \Guk\FinFormRow::factory($form_row_id);

                    $value = $request_cell_obj->getCorrectedValue();
                    if (!$value){
                        $value = $request_cell_obj->getValue();
                    }

                    if ($value) {
                        echo '<tr>';
                        echo '<td>' . $form_row_obj->getKbk() . '</td>';

                        echo '<td class="text-right">' . number_format(floatval($value), 0, '.', ' ') . '</td>';
                        echo '</tr>';
                    }
                }
            }

            echo '</table>';
        }

        echo \Cebera\BT::beginForm(\Guk\GukPages\ControllerDFO::dfoGenerateUrl(), \Guk\GukPages\ControllerDFO::OPERATION_CODE_ADD_PAYMENTS_GROUP);
        foreach ($vuz_request_ids_arr as $vuz_request_id) {
            echo \Cebera\BT::formGroup('Заявка ' . $vuz_request_id, '<input type=checkbox name="request_' . $vuz_request_id . '" checked>');
        }
        echo \Cebera\BT::formSubmit();
        echo \Cebera\BT::endForm();
    }
}