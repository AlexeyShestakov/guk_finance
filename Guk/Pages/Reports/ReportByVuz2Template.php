<?php

namespace Guk\Pages\Reports;

use Cebera\BT;

class ReportByVuz2Template
{
    const MODAL_EDIT_REQUEST_SUM = 'MODAL_EDIT_REQUEST_SUM';
    const OPERATION_EDIT_REQUEST_SUM = 'OPERATION_EDIT_REQUEST_SUM';
    const FIELD_REQUEST_ID = 'FIELD_REQUEST_ID';
    const FIELD_ROW_ID = 'FIELD_ROW_ID';
    const FIELD_CORRECTED_SUM = 'FIELD_CORRECTED_SUM';

    static public function render()
    {
        echo \Cebera\BT::pageHeader_plain('Заявки по ВУЗам');

        $form_id = \Guk\FinFormHelper::getCurrentFormId();
        \OLOG\Helpers::assert($form_id, 'Не назначена текущая форма.');

        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::div_plain('Финансовый период: ' . $form_obj->getComment());
        echo \Cebera\BT::delimiter();

        $row_ids_arr = $form_obj->getRowIdsArrByWeight();

        $all_request_for_form_ids_arr = \Guk\FinRequest::getRequestIdsArrForFormByCreatedAtDesc($form_id);

        $vuz_ids_arr = array();

        foreach ($all_request_for_form_ids_arr as $request_id) {
            $request_obj = \Guk\FinRequest::factory($request_id);
            $request_vuz_id = $request_obj->getVuzId();
            if (!in_array($request_vuz_id, $vuz_ids_arr)) {
                array_push($vuz_ids_arr, $request_vuz_id);
            }
        }

        echo '
        <style>
        .requested_sum_visibility {color: blue; display: none;}
        .corrected_sum_visibility {color: darkred;}
        .cut_sum_visibility {color: red; display: none;}
        </style>
        ';

        echo '<div><span class="glyphicon glyphicon-check requested_sum_visibility"></span> <a onclick="$(\'.requested_sum_visibility\').toggle(); return false;" href="#">запрошенная</a></div>';
        echo '<div><span class="glyphicon glyphicon-check corrected_sum_visibility"></span> <a onclick="$(\'.corrected_sum_visibility\').toggle(); return false;" href="#">скорректированная</a></div>';
        echo '<div><span class="glyphicon glyphicon-check cut_sum_visibility"></span> <a onclick="$(\'.cut_sum_visibility\').toggle(); return false;" href="#">секвестр</a></div>';

        echo '<table class="table table-condensed table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo \Cebera\BT::th('-');

        foreach ($row_ids_arr as $row_id) {
            $row_obj = \Guk\FinFormRow::factory($row_id);
            echo BT::th($row_obj->getId(), 'text-center');
        }

        $total_limit_sum = 0;

        echo \Cebera\BT::th('всего', 'text-center');
        echo '</tr>';

        echo '<tr>';
        echo \Cebera\BT::th('-');

        foreach ($row_ids_arr as $row_id) {
            $row_obj = \Guk\FinFormRow::factory($row_id);
            echo BT::th($row_obj->getLimit(), 'text-right');

            $total_limit_sum += $row_obj->getLimit();
        }

        echo \Cebera\BT::th($total_limit_sum, 'text-right');
        echo '</tr>';
        echo '</thead>';

        $total_requested_sums_by_row_id_arr = array();
        $total_corrected_sums_by_row_id_arr = array();

        foreach ($row_ids_arr as $form_row_id) {
            $total_requested_sums_by_row_id_arr[$form_row_id] = 0;
            $total_corrected_sums_by_row_id_arr[$form_row_id] = 0;
        }

        $total_requested_sum = 0;
        $total_corrected_sum = 0;

        foreach ($vuz_ids_arr as $vuz_id) {
            $vuz_obj = \Guk\Vuz::factory($vuz_id);

            $vuz_requested_sums_by_row_id_arr = array();
            $vuz_corrected_sums_by_row_id_arr = array();
            $vuz_requested_sum = 0;
            $vuz_corrected_sum = 0;

            $vuz_request_ids_arr = \OLOG\DB\DBWrapper::readColumn(
                \AppConfig\Config::DB_NAME_GUK_FINANCE,
                'select id from ' . \Guk\FinRequest::DB_TABLE_NAME . ' where vuz_id = ? and (status_code = ? or status_code = ?) order by created_at_ts desc',
                array($vuz_id, \Guk\FinRequest::STATUS_IN_GUK_REWIEW, \Guk\FinRequest::STATUS_APPROVED_BY_GUK)
            );

            foreach ($row_ids_arr as $form_row_id) {
                $vuz_requested_sums_by_row_id_arr[$form_row_id] = 0;
                $vuz_corrected_sums_by_row_id_arr[$form_row_id] = 0;

                foreach ($vuz_request_ids_arr as $vuz_request_id) {
                    $vuz_request_obj = \Guk\FinRequest::factory($vuz_request_id);

                    $requested_sum = $vuz_request_obj->getRequestedSumForRow($form_row_id);
                    $vuz_requested_sums_by_row_id_arr[$form_row_id] += $requested_sum;
                    $vuz_requested_sum += $requested_sum;
                    $total_requested_sums_by_row_id_arr[$form_row_id] += $requested_sum;
                    $total_requested_sum += $requested_sum;

                    $corrected_sum = $vuz_request_obj->getCorrectedSumForRow($form_row_id);
                    $vuz_corrected_sums_by_row_id_arr[$form_row_id] += intval($corrected_sum);
                    $vuz_corrected_sum += intval($corrected_sum);
                    $total_corrected_sums_by_row_id_arr[$form_row_id] += intval($corrected_sum);
                    $total_corrected_sum += intval($corrected_sum);
                }

            }

            echo '<tr>';
            echo '<td><b>' . $vuz_obj->getTitle() . ' <a href="#" onclick="$(\'.vuz_' . $vuz_id . '_row\').toggle(); return false;"><span class="glyphicon glyphicon-list"></span></a></b></td>';
            foreach ($row_ids_arr as $form_row_id) {
                echo '<td class="text-right">';
                echo '<div class="requested_sum_visibility">' . $vuz_requested_sums_by_row_id_arr[$form_row_id] . '</div>';
                echo '<div class="corrected_sum_visibility">' . $vuz_corrected_sums_by_row_id_arr[$form_row_id] . '</div>';
                echo '<div class="cut_sum_visibility">' . ($vuz_requested_sums_by_row_id_arr[$form_row_id] - $vuz_corrected_sums_by_row_id_arr[$form_row_id]) . '</div>';
                echo '</td>';
            }


            echo '<td class="text-right">';
            echo '<div class="requested_sum_visibility">' . $vuz_requested_sum . '</div>';
            echo '<div class="corrected_sum_visibility">' . $vuz_corrected_sum . '</div>';
            echo '<div class="cut_sum_visibility">' . ($vuz_requested_sum - $vuz_corrected_sum) . '</div>';
            echo '</td>';

            echo '</tr>';

            foreach ($vuz_request_ids_arr as $request_id){
                $request_obj = \Guk\FinRequest::factory($request_id);

                $request_requested_sum = 0;
                $request_corrected_sum = 0;

                echo '<tr class="vuz_' . $vuz_id . '_row info" style="display: none;">';
                echo '<td class="text-right">' .  $request_obj->getTitle() . '</td>';

                foreach ($row_ids_arr as $form_row_id) {
                    $requested_sum = $request_obj->getRequestedSumForRow($form_row_id);
                    $corrected_sum = $request_obj->getCorrectedSumForRow($form_row_id);
                    $request_requested_sum += $requested_sum;
                    $request_corrected_sum += $corrected_sum;
                    echo '<td class="text-right" data-toggle="modal" data-request_id="' . $request_id . '" data-row_id="' . $form_row_id . '" data-corrected_sum="' . $corrected_sum . '" data-target="#' . self::MODAL_EDIT_REQUEST_SUM . '" style="cursor: pointer;">';
                    echo '<div class="requested_sum_visibility">' . $requested_sum . '</div>';
                    echo '<div class="corrected_sum_visibility">' . $corrected_sum . '</div>';
                    echo '<div class="cut_sum_visibility">' . ($requested_sum - $corrected_sum) . '</div>';
                    echo '</td>';
                }

                echo '<td class="text-right">';
                echo '<div class="requested_sum_visibility">' . $request_requested_sum . '</div>';
                echo '<div class="corrected_sum_visibility">' . $request_corrected_sum . '</div>';
                echo '<div class="cut_sum_visibility">' . ($request_requested_sum - $request_corrected_sum) . '</div>';
                echo '</td>';

                echo '</tr>';

            }
        }

        // TOTALS ROW

        echo '<tr>';
        echo '<td class="text-right">Всего</td>';

        foreach ($row_ids_arr as $form_row_id) {
            echo '<td class="text-right">';
            echo '<div class="requested_sum_visibility">' . $total_requested_sums_by_row_id_arr[$form_row_id] . '</div>';
            echo '<div class="corrected_sum_visibility">' . $total_corrected_sums_by_row_id_arr[$form_row_id] . '</div>';
            echo '<div class="cut_sum_visibility">' . ($total_requested_sum - $total_corrected_sum) . '</div>';
            echo '</td>';
        }

        echo '<td class="text-right">';
        echo '<div class="requested_sum_visibility">' . $total_requested_sum . '</div>';
        echo '<div class="corrected_sum_visibility">' . $total_corrected_sum . '</div>';
        echo '<div class="cut_sum_visibility">' . ($total_requested_sum - $total_corrected_sum) . '</div>';
        echo '</td>';


        echo '</tr>';

        // REMAINS ROW

        echo '<tr>';
        echo '<td class="text-right">Резерв</td>';

        foreach ($row_ids_arr as $form_row_id) {
            $row_obj = \Guk\FinFormRow::factory($form_row_id);
            echo '<td class="text-right">';
            echo '<div class="requested_sum_visibility">' . ($row_obj->getLimit() - $total_requested_sums_by_row_id_arr[$form_row_id]) . '</div>';
            echo '<div class="corrected_sum_visibility">' . ($row_obj->getLimit() - $total_corrected_sums_by_row_id_arr[$form_row_id]) . '</div>';
            echo '</td>';
        }

        echo '<td class="text-right">';
        echo '<div class="requested_sum_visibility">' . ($total_limit_sum - $total_requested_sum) . '</div>';
        echo '<div class="corrected_sum_visibility">' . ($total_limit_sum - $total_corrected_sum) . '</div>';
        echo '</td>';

        echo '</tr>';


        echo '</table>';


        echo BT::beginModalForm(self::MODAL_EDIT_REQUEST_SUM, 'Корректировка запрошенной суммы', ControllerReports::reportsByVuzAction(1), self::OPERATION_EDIT_REQUEST_SUM);
        echo BT::hiddenInput(self::FIELD_REQUEST_ID);
        echo BT::hiddenInput(self::FIELD_ROW_ID);
        echo BT::formGroup('Новая сумма', BT::formInput(self::FIELD_CORRECTED_SUM));
        echo BT::endModalForm();

        ?>

        <script>
            $('#<?= self::MODAL_EDIT_REQUEST_SUM ?>').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                //var title = button.data('title');
                //var col_id = button.data('col_id');
                var modal = $(this);
                modal.find('.modal-body #<?= self::FIELD_REQUEST_ID ?>').val(button.data('request_id'));
                modal.find('.modal-body #<?= self::FIELD_ROW_ID ?>').val(button.data('row_id'));
                modal.find('.modal-body #<?= self::FIELD_CORRECTED_SUM ?>').val(button.data('corrected_sum'));
            })
        </script>

        <?php
    }
}