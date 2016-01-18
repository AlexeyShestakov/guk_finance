<?php
/**
 * @var $request_id
 */

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

?>

<h1><a href="<?= \Guk\FinFormsPage\ControllerFinFormsPage::getFinRequestsUrl() ?>">Заявки</a> / <?= $request_obj->getTitle() ?></h1>

<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinRequestUrl($request_obj->getId()); ?>">Данные</a></li>
    <li role="presentation"><a href="">История</a></li>
    <li role="presentation"><a href="<?= \Guk\FinFormsPage\ControllerFinFormsPage::requestPaymentsUrl($request_id); ?>">Платежи</a></li>
</ul>

<div>&nbsp;</div>

<table class="table table-bordered table-condensed table-striped">

    <?php

    echo '<thead><tr>';
    echo '<th>-</th>';

    foreach ($col_ids_arr as $col_id){
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<th>' . mb_substr($col_obj->getTitle(), 0, 4) . '...</th>';
    }

    echo '<th>Лимит</th>';
    echo '<th>Всего запрошено</th>';
    echo '<th>Всего одобрено</th>';

    echo '</tr></thead>';

    foreach ($row_ids_arr as $row_id){
        $row_obj = \Guk\FinFormRow::factory($row_id);

        echo '<tr>';
        echo '<td>' . $row_obj->getId() . '</td>';

        foreach ($col_ids_arr as $col_id){
            $col_obj = \Guk\FinFormCol::factory($col_id);

            if ($col_obj->getIsEditableByVuz()){
                $cell_value = '';

                $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($request_id, $row_id, $col_id);
                if ($request_cell_obj){
                    $cell_value = $request_cell_obj->getValue();
                    echo '<td><b>';
                    echo '<a href="#" onclick="$(\'#request_cell_id\').val(\'' . $request_cell_obj->getId() . '\'); $(\'#editValueModal_value\').val(\'' . $cell_value . '\'); $(\'#editValueModal\').modal();">' . $cell_value . '</a>';
                    echo '</b></td>';
                } else {
                    echo '<td></td>';
                }

            } else {
                $cell_value = $row_obj->getId() . '-' . $col_obj->getId();
                $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());

                if ($cell_obj){
                    $cell_value = $cell_obj->getValue();
                    echo '<td>' . $cell_value . '</td>';
                } else {
                    echo '<td></td>';
                }

            }

        }

        echo '<td>' . $row_obj->getLimit() . '</td>';

        $requested_sum = 0;
        $approved_sum = 0;

        $request_cell_ids_arr = \Cebera\DB\DBWrapper::readColumn(
            \Cebera\Conf::DB_NAME_GUK_FINANCE,
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

        echo '<td>' . $requested_sum . '</td>';
        echo '<td>' . $approved_sum . '</td>';


        echo '</tr>';
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
            <form method="post" action="<?= \Guk\FinFormsPage\ControllerFinFormsPage::getFinRequestUrl($request_obj->getId()) ?>">
                <input type="hidden" name="a" value="set_request_cell_value"/>
                <input type="hidden" id="request_cell_id" name="request_cell_id" value=""/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Изменение значения</h4>
                </div>
                <div class="modal-body">
                    <p>Введите новое значение.</p>
                    <div><input class="form-control" id="editValueModal_value" name="value" placeholder="Значение"></div>
                    <div>&nbsp;</div>
                    <p>Опишите причину изменения значения.</p>
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
            <form method="post" action="<?= \Guk\FinFormsPage\ControllerFinFormsPage::getFinRequestUrl($request_obj->getId()) ?>">
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
            <form method="post" action="<?= \Guk\FinFormsPage\ControllerFinFormsPage::getFinRequestUrl($request_obj->getId()) ?>">
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