<?php

namespace Guk\GukPages\Templates;

class ReportByVuzTemplate
{

    static public function render(){
        echo \Cebera\BT::h1_plain('Заявки по ВУЗам');

        $form_id = \Guk\FinFormHelper::getCurrentFormId();
        \OLOG\Helpers::assert($form_id, 'Не назначена текущая форма.');

        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::div_plain('Финансовый период: ' . $form_obj->getComment());
        echo \Cebera\BT::div_plain('&nbsp;');

        $row_ids_arr = $form_obj->getRowIdsArrByWeight();
        $col_ids_arr = $form_obj->getColIdsArrByWeight();

        $requested_sum_col_id = $form_obj->getRequestedSumColId();
        \OLOG\Helpers::assert($requested_sum_col_id, 'В выбранной форме нет колонки с запрошенной суммой.');

        $all_request_for_form_ids_arr = \Guk\FinRequest::getRequestIdsArrForFormByCreatedAtDesc($form_id);

        $vuz_ids_arr = array();

        foreach ($all_request_for_form_ids_arr as $request_id){
            $request_obj = \Guk\FinRequest::factory($request_id);
            $request_vuz_id = $request_obj->getVuzId();
            if (!in_array($request_vuz_id, $vuz_ids_arr)){
                array_push($vuz_ids_arr, $request_vuz_id);
            }
        }

        echo '<table class="table table-condensed table-bordered">';
        echo '<thead><tr>';
        echo \Cebera\BT::th('ВУЗ');
        echo \Cebera\BT::th('Заявок');
        echo \Cebera\BT::th('Запрошено (тыс. руб.)');
        echo \Cebera\BT::th('Выделено (тыс. руб.)');
        echo \Cebera\BT::th('Секвестр (тыс. руб.)');
        echo \Cebera\BT::th('Израсходовано ВУЗом (тыс. руб.)');
        echo '</tr></thead>';

        foreach ($vuz_ids_arr as $vuz_id){
            $vuz_obj = \Guk\Vuz::factory($vuz_id);
            $vuz_requested_sum = 0;
            $vuz_corrected_sum = 0;

            $by_kbk_arr = [];

            $vuz_request_ids_arr = \OLOG\DB\DBWrapper::readColumn(
                \AppConfig\Config::DB_NAME_GUK_FINANCE,
                'select id from ' . \Guk\FinRequest::DB_TABLE_NAME . ' where vuz_id = ? and status_code in (?) order by created_at_ts desc',
                array($vuz_id, \Guk\FinRequest::STATUS_APPROVED_BY_GUK)
            );

            foreach ($vuz_request_ids_arr as $vuz_request_id){
                $vuz_request_obj = \Guk\FinRequest::factory($vuz_request_id);

                foreach ($row_ids_arr as $form_row_id){
                    $form_row_obj = \Guk\FinFormRow::factory($form_row_id);
                    $row_values = ['requested' => 0, 'corrected' => 0];

                    $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($vuz_request_id, $form_row_id, $requested_sum_col_id);

                    if ($request_cell_obj) {
                        $corrected_value = $request_cell_obj->getCorrectedValue();
                        if (!$corrected_value){
                            $corrected_value = $request_cell_obj->getValue();
                        }

                        if ($corrected_value) {
                            $vuz_corrected_sum += intval($corrected_value);
                            $row_values['corrected'] = intval($corrected_value);
                        }

                        if ($request_cell_obj->getValue()){
                            $vuz_requested_sum += intval($request_cell_obj->getValue());
                            $row_values['requested'] = intval($request_cell_obj->getValue());
                        }
                    }

                    if (!array_key_exists($form_row_obj->getKbk(), $by_kbk_arr)){
                        $by_kbk_arr[$form_row_obj->getId()] = $row_values;
                    } else {
                        $by_kbk_arr[$form_row_obj->getId()]['requested'] += $row_values['requested'];
                        $by_kbk_arr[$form_row_obj->getId()]['corrected'] += $row_values['corrected'];
                    }
                }

            }

            echo '<tr>';
            echo '<td><b>' . $vuz_obj->getTitle() . '</b></td>';
            echo '<td class="text-right"><b>' . count($vuz_request_ids_arr) . '</b></td>';
            echo '<td class="text-right"><b>' . number_format(floatval($vuz_requested_sum), 0, '.', ' ') . '</b></td>';
            echo '<td class="text-right"><b>' . number_format(floatval($vuz_corrected_sum), 0, '.', ' ') . '</b></td>';
            echo '<td class="text-right"><b>' . number_format(floatval($vuz_requested_sum - $vuz_corrected_sum), 0, '.', ' ') . '</b></td>';
            echo '<td class="text-right"><b>#</b></td>';
            echo '</tr>';

            foreach ($by_kbk_arr as $form_row_id => $values_arr){
                echo '<tr>';
                echo '<td class="text-right">Строка ' . $form_row_id . '</td>';
                echo '<td class="text-right">-</td>';
                echo '<td class="text-right">' . number_format(floatval($values_arr['requested']), 0, '.', ' ') . '</td>';
                echo '<td class="text-right">' . number_format(floatval($values_arr['corrected']), 0, '.', ' ') . '</td>';
                echo '<td class="text-right">' . number_format(floatval($values_arr['requested'] - $values_arr['corrected']), 0, '.', ' ') . '</td>';

                $expense_str = '';
                $vuz_expense_obj = \Guk\VuzExpenses::getObjForVuzAndFormRow($vuz_id, $form_row_id);
                if ($vuz_expense_obj){
                    $expense_str = $vuz_expense_obj->getExpensesRub();
                }

                echo \Cebera\BT::td(number_format(floatval($expense_str), 0, '.', ' '));

                echo '</tr>';
            }
        }

        echo '</table>';
   }
}