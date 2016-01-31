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
        $form_id = \Guk\FinFormHelper::getCurrentFormId();
        \OLOG\Helpers::assert($form_id, 'Не назначена текущая форма.');

        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::pageHeader_plain($form_obj->getComment() . ': заявки по ВУЗам');

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

        echo BT::delimiter();

        $detail_cols_id_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormByWeight($form_id);

        $detail_col_links_arr = array();

        foreach ($detail_cols_id_arr as $detail_col_id){
            $detail_col_obj = \Guk\DetailColumn::factory($detail_col_id);
            array_push($detail_col_links_arr, BT::a(ControllerReports::reportsByVuzAction(1) . '?detail_col_id=' . $detail_col_id, $detail_col_obj->getTitle()));
        }

        echo '<div>Дополнительная детализация: ';
        echo implode(' | ', $detail_col_links_arr);
        echo '</div>';

        echo BT::delimiter();

        $detail_col_to_expand_id = 0;
        if (isset($_GET['detail_col_id'])){
            $detail_col_to_expand_id = $_GET['detail_col_id'];
        }


        echo '<table class="table table-condensed table-bordered">';
        echo '<thead>';
        echo '<tr style="background-color: #eee;">';
        echo \Cebera\BT::th('Статья финансирования');

        foreach ($row_ids_arr as $row_id) {

            if ($detail_col_to_expand_id) {
                $detail_col_to_expand_obj = \Guk\DetailColumn::factory($detail_col_to_expand_id);
                $expand_vocab_id = $detail_col_to_expand_obj->getVocabularyId();

                $term_ids = \Guk\Term::getTermIdsArrForVocabularyByTitle($expand_vocab_id);

                foreach ($term_ids as $term_id) {
                    echo '<th></th>';

                }
            }

            $row_obj = \Guk\FinFormRow::factory($row_id);
            echo BT::th($row_obj->getKbk(), 'text-center');
        }

        echo \Cebera\BT::th('всего', 'text-center');
        echo '</tr>';

        if ($detail_col_to_expand_id) {
            $detail_col_to_expand_obj = \Guk\DetailColumn::factory($detail_col_to_expand_id);
            $expand_vocab_id = $detail_col_to_expand_obj->getVocabularyId();

            $term_ids = \Guk\Term::getTermIdsArrForVocabularyByTitle($expand_vocab_id);

            echo '<tr style="background-color: #eee;">';
            echo \Cebera\BT::th($detail_col_to_expand_obj->getTitle());

            foreach ($row_ids_arr as $row_id) {

                foreach ($term_ids as $term_id) {
                    $term_obj = \Guk\Term::factory($term_id);
                    echo '<th>' . $term_obj->getTitle() . '</th>';

                }

                echo BT::th('', 'text-center');
            }

            echo \Cebera\BT::th('всего', 'text-center');
            echo '</tr>';
        }

        $total_limit_sum = 0;

        echo '<tr style="background-color: #eee;">';
        echo \Cebera\BT::th('Лимит');

        foreach ($row_ids_arr as $row_id) {

            if ($detail_col_to_expand_id) {
                $detail_col_to_expand_obj = \Guk\DetailColumn::factory($detail_col_to_expand_id);
                $expand_vocab_id = $detail_col_to_expand_obj->getVocabularyId();

                $term_ids = \Guk\Term::getTermIdsArrForVocabularyByTitle($expand_vocab_id);

                foreach ($term_ids as $term_id) {
                    echo '<th></th>';
                }
            }

            $row_obj = \Guk\FinFormRow::factory($row_id);
            echo BT::th($row_obj->getLimit(), 'text-right');

            $total_limit_sum += $row_obj->getLimit();
        }

        echo \Cebera\BT::th($total_limit_sum, 'text-right');
        echo '</tr>';
        echo '</thead>';

        $total_sums_by_row_id_obj_arr = array();

        foreach ($row_ids_arr as $form_row_id) {
            $total_sums_by_row_id_obj_arr[$form_row_id] = new Sums();
        }

        $total_sums_obj = new Sums();

        foreach ($vuz_ids_arr as $vuz_id) {
            $vuz_obj = \Guk\Vuz::factory($vuz_id);

            $vuz_sums_by_row_id_obj_arr = array();
            $vuz_sums_obj = new Sums();

            $vuz_request_ids_arr = \OLOG\DB\DBWrapper::readColumn(
                \AppConfig\Config::DB_NAME_GUK_FINANCE,
                'select id from ' . \Guk\FinRequest::DB_TABLE_NAME . ' where fin_form_id = ? and vuz_id = ? and (status_code = ? or status_code = ?) order by created_at_ts desc',
                array($form_id, $vuz_id, \Guk\FinRequest::STATUS_IN_GUK_REWIEW, \Guk\FinRequest::STATUS_APPROVED_BY_GUK)
            );

            foreach ($row_ids_arr as $form_row_id) {
                $vuz_sums_by_row_id_obj_arr[$form_row_id] = new Sums();

                foreach ($vuz_request_ids_arr as $vuz_request_id) {
                    $vuz_request_obj = \Guk\FinRequest::factory($vuz_request_id);

                    $requested_sum = $vuz_request_obj->getRequestedSumForRow($form_row_id);
                    $corrected_sum = $vuz_request_obj->getCorrectedSumForRow($form_row_id);

                    $vuz_sums_obj->append($requested_sum, $corrected_sum);
                    $total_sums_obj->append($requested_sum, $corrected_sum);
                    $total_sums_by_row_id_obj_arr[$form_row_id]->append($requested_sum, $corrected_sum);
                    $vuz_sums_by_row_id_obj_arr[$form_row_id]->append($requested_sum, $corrected_sum);
                }

            }

            echo '<tr>';
            echo '<td>' . $vuz_obj->getTitle() . ' <a href="#" onclick="$(\'.vuz_' . $vuz_id . '_row\').toggle(); return false;">заявки</a></td>';
            foreach ($row_ids_arr as $form_row_id) {

                if ($detail_col_to_expand_id){
                    $detail_col_to_expand_obj = \Guk\DetailColumn::factory($detail_col_to_expand_id);
                    $expand_vocab_id = $detail_col_to_expand_obj->getVocabularyId();

                    $term_ids = \Guk\Term::getTermIdsArrForVocabularyByTitle($expand_vocab_id);

                    foreach ($term_ids as $term_id) {
                        echo '<th></th>';
                    }
                }

                echo '<td class="text-right">';
                echo $vuz_sums_by_row_id_obj_arr[$form_row_id]->render();
                echo '</td>';
            }

            echo '<td class="text-right">';
            echo $vuz_sums_obj->render();
            echo '</td>';

            echo '</tr>';

            foreach ($vuz_request_ids_arr as $request_id){
                $request_obj = \Guk\FinRequest::factory($request_id);

                $request_sums_obj = new Sums();
                echo '<tr class="vuz_' . $vuz_id . '_row info" style="display: none;">';
                echo '<td class="text-right">' .  $request_obj->getTitle() . '</td>';

                foreach ($row_ids_arr as $form_row_id) {


                    if ($detail_col_to_expand_id) {
                        $detail_col_to_expand_obj = \Guk\DetailColumn::factory($detail_col_to_expand_id);
                        $expand_vocab_id = $detail_col_to_expand_obj->getVocabularyId();

                        $term_ids = \Guk\Term::getTermIdsArrForVocabularyByTitle($expand_vocab_id);

                        foreach ($term_ids as $term_id) {
                            //echo '<td>' . $term_id . '</td>';
                            $detail_cell_ids_arr = \Guk\DetailCell::getIdsArrForRequestAndFormRowAndTermAndCol($request_id, $form_row_id, $term_id, $detail_col_to_expand_id);

                            $detail_sum = 0;

                            foreach ($detail_cell_ids_arr as $detail_cell_id) {
                                $detail_cell_obj = \Guk\DetailCell::factory($detail_cell_id);
                                $detail_row_id = $detail_cell_obj->getDetailRowId();
                                $detail_row_obj = \Guk\DetailRow::factory($detail_row_id);
                                $detail_sum += $detail_row_obj->getRequestedSum();
                            }

                            echo '<td class="text-right">' . $detail_sum . '</td>';

                        }
                    }


                    $requested_sum = $request_obj->getRequestedSumForRow($form_row_id);
                    $corrected_sum = $request_obj->getCorrectedSumForRow($form_row_id);

                    $request_sums_obj->append($requested_sum, $corrected_sum);

                    echo '<td class="text-right" data-toggle="modal" data-request_id="' . $request_id . '" data-row_id="' . $form_row_id . '" data-corrected_sum="' . $corrected_sum . '" data-target="#' . self::MODAL_EDIT_REQUEST_SUM . '" style="cursor: pointer;">';

                    echo '<div class="requested_sum_visibility">' . $requested_sum . '</div>';
                    echo '<div class="corrected_sum_visibility">' . $corrected_sum . '</div>';
                    echo '<div class="cut_sum_visibility">' . ($requested_sum - $corrected_sum) . '</div>';




                    echo '</td>';
                }

                echo '<td class="text-right">';
                echo $request_sums_obj->render();
                echo '</td>';

                echo '</tr>';

            }
        }

        // TOTALS ROW

        echo '<tr>';
        echo '<td class="text-right">Всего</td>';

        foreach ($row_ids_arr as $form_row_id) {
            if ($detail_col_to_expand_id) {
                $detail_col_to_expand_obj = \Guk\DetailColumn::factory($detail_col_to_expand_id);
                $expand_vocab_id = $detail_col_to_expand_obj->getVocabularyId();

                $term_ids = \Guk\Term::getTermIdsArrForVocabularyByTitle($expand_vocab_id);

                foreach ($term_ids as $term_id) {
                    echo '<td></td>';
                }
            }

            echo '<td class="text-right">';
            echo $total_sums_by_row_id_obj_arr[$form_row_id]->render();
            echo '</td>';
        }

        echo '<td class="text-right">';
        echo $total_sums_obj->render();
        echo '</td>';


        echo '</tr>';

        // REMAINS ROW

        echo '<tr>';
        echo '<td class="text-right">Резерв</td>';

        foreach ($row_ids_arr as $form_row_id) {
            if ($detail_col_to_expand_id) {
                $detail_col_to_expand_obj = \Guk\DetailColumn::factory($detail_col_to_expand_id);
                $expand_vocab_id = $detail_col_to_expand_obj->getVocabularyId();

                $term_ids = \Guk\Term::getTermIdsArrForVocabularyByTitle($expand_vocab_id);

                foreach ($term_ids as $term_id) {
                    echo '<td></td>';
                }
            }

            $row_obj = \Guk\FinFormRow::factory($form_row_id);
            echo '<td class="text-right">';
            echo '<div class="requested_sum_visibility">' . ($row_obj->getLimit() - $total_sums_by_row_id_obj_arr[$form_row_id]->requested) . '</div>';
            echo '<div class="corrected_sum_visibility">' . ($row_obj->getLimit() - $total_sums_by_row_id_obj_arr[$form_row_id]->corrected) . '</div>';
            echo '</td>';
        }

        echo '<td class="text-right">';
        echo '<div class="requested_sum_visibility">' . ($total_limit_sum - $total_sums_obj->requested) . '</div>';
        echo '<div class="corrected_sum_visibility">' . ($total_limit_sum - $total_sums_obj->corrected) . '</div>';
        echo '</td>';

        echo '</tr>';


        echo '</table>';


        echo BT::beginModalForm(self::MODAL_EDIT_REQUEST_SUM, 'Корректировка запрошенной суммы', ControllerReports::reportsByVuzAction(1), self::OPERATION_EDIT_REQUEST_SUM);
        echo BT::hiddenInput(self::FIELD_REQUEST_ID);
        echo BT::hiddenInput(self::FIELD_ROW_ID);
        echo BT::formGroup('Новая сумма', BT::formInput(self::FIELD_CORRECTED_SUM));
        echo BT::formGroup('', '<a href="#" onclick="open_details(); return false;">Открыть детализацию</a>');
        echo '<div id="details_container"></div>';
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
                modal.find('.modal-body #details_container').html('');
            });

            function open_details(){
                var modal = $('#<?= self::MODAL_EDIT_REQUEST_SUM ?>');
                var request_id = modal.find('.modal-body #<?= self::FIELD_REQUEST_ID ?>').val();
                var form_row_id = modal.find('.modal-body #<?= self::FIELD_ROW_ID ?>').val();
                ajax_context_obj = {modal: modal};

                $.ajax({
                        method: "GET",
                        url: "/guk/reports/details_for_request_and_form_row/" + request_id + "/" + form_row_id,
                        context: ajax_context_obj
                    })
                    .done(function( html ) {
                        this.modal.find('.modal-body #details_container').html(html);
                        });


            }
        </script>

        <?php
    }
}