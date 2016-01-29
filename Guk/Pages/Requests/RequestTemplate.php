<?php

namespace Guk\Pages\Requests;

use Cebera\BT;

class RequestTemplate
{
    static public function render($request_id){

        $request_obj = \Guk\FinRequest::factory($request_id);
        $form_id = $request_obj->getFinFormId();

        $form_obj = \Guk\FinForm::factory($form_id);

        $col_ids_arr = $form_obj->getColIdsArrByWeight();
        $row_ids_arr = $form_obj->getRowIdsArrByWeight();

        $requested_sum_col_id = 0;

        foreach ($col_ids_arr as $col_id) {
            $col_obj = \Guk\FinFormCol::factory($col_id);
            if ($col_obj->getIsRequestedSum()){
                $requested_sum_col_id = $col_id;
            }
        }

        if (!$requested_sum_col_id){
            echo '<div class="alert alert-warning" role="alert">В выбранной форме нет колонки с запрошенной суммой.</div>';
            return;
        }

        echo BT::pageHeader_plain('<a href="' . \Guk\Pages\Requests\ControllerRequests::getFinRequestsUrl() . '">Заявки</a> / ' . $request_obj->getTitle());

        ?>

        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo \Guk\Pages\Requests\ControllerRequests::getFinRequestUrl($request_obj->getId()); ?>">Данные</a></li>
            <li role="presentation"><a href="">История</a></li>
            <li role="presentation"><a href="<?= \Guk\Pages\Requests\ControllerRequests::requestPaymentsUrl($request_id); ?>">Платежи</a></li>
        </ul>

        <div>&nbsp;</div>

        <table class="table table-bordered table-condensed">

            <?php

            echo '<thead><tr>';
            echo '<th>-</th>';

            foreach ($col_ids_arr as $col_id){
                $col_obj = \Guk\FinFormCol::factory($col_id);

                echo '<th class="text-center"><small>' . $col_obj->getTitle() . '</small></th>';
            }

            //echo '<th class="text-center"><small>Лимит/<br>Запрошено/<br>Одобрено</small></th>';
            echo '<th class="text-center"><small>Детали</small></th>';

            echo '</tr></thead>';

            foreach ($row_ids_arr as $row_id){
                $row_obj = \Guk\FinFormRow::factory($row_id);
                $cols_count = 0;

                echo '<tr>';
                echo '<td>' . $row_obj->getId() . '</td>';
                $cols_count++;

                foreach ($col_ids_arr as $col_id){
                    $col_obj = \Guk\FinFormCol::factory($col_id);

                    if ($col_obj->getIsEditableByVuz()){
                        $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($request_id, $row_id, $col_id);
                        if ($request_cell_obj){
                            $cell_value = $request_cell_obj->getValue();
                            $corrected_value = $request_cell_obj->getCorrectedValue();

                            $cell_text =  $cell_value;
                            if ($corrected_value != ''){
                                $cell_text .= ' / <span style="color: red;">' . $corrected_value . '</span>';
                            }

                            echo '<td class="text-right"><small><b>';
                            echo '<a href="#" onclick="$(\'#request_cell_id\').val(\'' . $request_cell_obj->getId() . '\'); $(\'#editValueModal_value\').val(\'' . $cell_value . '\'); $(\'#editValueModal_corrected_value\').val(\'' . $corrected_value . '\'); $(\'#editValueModal\').modal();">' . $cell_text . '</a>';
                            echo '</b></small></td>';
                            $cols_count++;
                        } else {
                            echo '<td><small></small></td>';
                            $cols_count++;
                        }
                    } else {
                        $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());

                        echo '<td class="text-center"><small>';

                        if ($cell_obj){
                            $cell_value = $cell_obj->getValue();
                            echo $cell_value;
                        }

                        echo '</small></td>';
                        $cols_count++;

                    }

                }

                /*
                $requested_sum = 0;
                $approved_sum = 0;

                $request_cell_ids_arr = \OLOG\DB\DBWrapper::readColumn(
                    \AppConfig\Config::DB_NAME_GUK_FINANCE,
                    'select id from ' . \Guk\FinRequestCell::DB_TABLE_NAME . ' where row_id = ? and col_id = ?',
                    array($row_id, $requested_sum_col_id)
                );

                foreach ($request_cell_ids_arr as $request_cell_id){
                    $request_cell_obj = \Guk\FinRequestCell::factory($request_cell_id);

                    $requested_sum += intval($request_cell_obj->getValue());

                    $cell_request_id = $request_cell_obj->getFinRequestId();
                    $cell_request_obj = \Guk\FinRequest::factory($cell_request_id);

                    $cell_request_status_code = $cell_request_obj->getStatusCode();

                    if ($cell_request_status_code == \Guk\FinRequest::STATUS_APPROVED_BY_GUK){
                        $approved_sum += intval($request_cell_obj->getValue());
                    }
                }

                echo '<td class="text-right"><small>' . number_format(floatval($row_obj->getLimit()), 0, '.', ' ') . '<br>' . number_format(floatval($requested_sum), 0, '.', ' ') . '<br>' . number_format(floatval($approved_sum), 0, '.', ' ') . '</small></td>';
                */

                $cols_count++;

                $row_extras_htmlid = 'request_' . $request_id . '_row_' . $row_obj->getId() . '_extras';
                echo '<td style="text-align: center;"><small><a href="#" class="glyphicon glyphicon-tasks" onclick="$(\'#' . $row_extras_htmlid  . '\').slideToggle(0); return false;"></a></small></td>';
                $cols_count++;

                echo '</tr>';

                $details_table_htmlid = 'request_' . $request_id . '_details_table_for_row_' . $row_obj->getId();
                echo '<tr style="display: none;" id="' . $row_extras_htmlid . '">';
                echo '<td style="background-color: #ddd;" colspan="' . $cols_count . '">';
                echo '<table id="' . $details_table_htmlid . '"  class="table table-bordered table-condensed">';
                echo '<thead><tr>';

                $detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormById($form_id);
                foreach ($detail_column_ids_arr as $detail_column_id){
                    $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);
                    echo '<th class="text-center"><small>' . $detail_column_obj->getTitle() . '</small></th>';
                }

                echo '</thead>';

                $detail_row_ids_arr = \Guk\DetailRow::getDetailRowIdsArrForRequestAndFormRowById($request_id, $row_id);
                foreach ($detail_row_ids_arr as $detail_row_id){
                    $detail_row_obj = \Guk\DetailRow::factory($detail_row_id);

                    $detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormById($form_id);

                    echo '<tr>';
                    foreach ($detail_column_ids_arr as $detail_column_id) {
                        $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);

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

                echo '</td></tr>';
            }


            ?>

        </table>

        <div>

            <?php

            if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_IN_GUK_REWIEW) {
                echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#approveModal">Принять</button>&nbsp;';
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">Отклонить</button>';
            }

            ?>


        </div>

        <div class="modal fade" id="editValueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="<?= \Guk\Pages\Requests\ControllerRequests::getFinRequestUrl($request_obj->getId()) ?>">
                        <input type="hidden" name="a" value="set_request_cell_value"/>
                        <input type="hidden" id="request_cell_id" name="request_cell_id" value=""/>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Изменение значения</h4>
                        </div>
                        <div class="modal-body">
                            <p>Запрошенное значение:</p>
                            <div><input class="form-control" id="editValueModal_value" name="value" placeholder="Значение" disabled></div>
                            <div>&nbsp;</div>
                            <p>Введите скорректированное значение:</p>
                            <div><input class="form-control" id="editValueModal_corrected_value" name="corrected_value" placeholder="Значение"></div>
                            <div>&nbsp;</div>
                            <p>Опишите причину изменения значения:</p>
                            <div><input class="form-control" id="editValueModal_value" name="comment" placeholder="Комментарий"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <input type="submit" class="btn btn-primary" value="Изменить"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="<?= \Guk\Pages\Requests\ControllerRequests::getFinRequestUrl($request_obj->getId()) ?>">
                        <input type="hidden" name="a" value="set_request_status_code"/>
                        <input type="hidden" name="status_code" value="<?= \Guk\FinRequest::STATUS_REJECTED_BY_GUK ?>"/>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Отклонение заявки</h4>
                        </div>
                        <div class="modal-body">
                            <p>Опишите причину отклонения заявки.</p>
                            <input class="form-control" name="comment" placeholder="Комментарий">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <input type="submit" class="btn btn-default btn-danger" value="Отклонить"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="<?= \Guk\Pages\Requests\ControllerRequests::getFinRequestUrl($request_obj->getId()) ?>">
                        <input type="hidden" name="a" value="set_request_status_code"/>
                        <input type="hidden" name="status_code" value="<?= \Guk\FinRequest::STATUS_APPROVED_BY_GUK ?>"/>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Принятие заявки</h4>
                        </div>
                        <div class="modal-body">
                            <p>Оставьте комментарий к принятию заявки.</p>
                            <input class="form-control" name="comment" placeholder="Комментарий">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <input type="submit" class="btn btn-default btn-success" value="Принять"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}