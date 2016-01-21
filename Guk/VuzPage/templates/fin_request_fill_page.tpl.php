<?php
/**
 * @var $request_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);
$form_id = $request_obj->getFinFormId();

$form_obj = \Guk\FinForm::factory($form_id);

$col_ids_arr = $form_obj->getColIdsArrByWeight();
$row_ids_arr = $form_obj->getRowIdsArrByWeight();

?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($request_obj->getTitle()); ?></h1>

<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()); ?>">Заполнение</a></li>
    <li role="presentation"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestEditUrl($request_obj->getId()); ?>">Параметры</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestUploadUrl($request_obj->getId()) ?>">Обоснование</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestHistoryUrl($request_obj->getId()) ?>">История</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestPrintUrl($request_obj->getId()) ?>">Печать</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::requestPaymentsPageUrl($request_obj->getId()) ?>">Платежи</a></li>
</ul>

<div>&nbsp;</div>

<?php

if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_IN_GUK_REWIEW){
    echo '<div class="alert alert-info" role="alert">Заявка находится на утверждении в ГУК, изменение данных запрещено.</div>';
}

?>

<table class="table table-bordered table-condensed table-striped">

    <?php

    echo '<thead><tr>';
    echo '<th><small>№</small></th>';

    foreach ($col_ids_arr as $col_id){
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<th style="text-align: center;"><small>' . $col_obj->getTitle() . '</small></th>';
    }

    echo '<th style="text-align: center;"><small>Детали</small></th>';
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
                }

                echo '<td>';

                if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_DRAFT ){
                    echo '<form method="post" action="' . \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()) . '">';
                    echo '<input type="hidden" name="a" value="set_value"/>';
                    echo '<input type="hidden" name="row_id" value="' . $row_obj->getId() . '"/>';
                    echo '<input type="hidden" name="col_id" value="' . $col_obj->getId() . '"/>';
                    echo '<input name="value" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $cell_value . '"/></form>';
                } else {
                    echo $cell_value;
                }


                echo '</td>';
            } else {
                $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());

                if ($cell_obj){
                    echo '<td style="text-align: center;"><small>' . $cell_obj->getValue() . '</small></td>';
                } else {
                    echo '<td></td>';
                }

            }

        }

        echo '<td style="text-align: center;"><small><span class="glyphicon glyphicon-list"></span></small></td>';
        echo '</tr>';
    }


    ?>

</table>

<div>

    <?php

    if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_DRAFT) {
        echo '<form style="display: inline;" method="post" action="' . \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()) . '">';
        echo '<input type="hidden" name="a" value="set_request_status_code"/>';
        echo '<input type="hidden" name="status_code" value="' . \Guk\FinRequest::STATUS_IN_GUK_REWIEW . '"/>';
        echo '<input type="submit" class="btn btn-default btn-primary" value="Отправить в ГУК"/>';
        echo '</form>&nbsp;';

        echo '<form style="display: inline;" method="post" action="' . \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()) . '">';
        echo '<input type="hidden" name="a" value="set_request_status_code"/>';
        echo '<input type="hidden" name="status_code" value="' . \Guk\FinRequest::STATUS_DISCARDED_BY_VUZ . '"/>';
        echo '<input type="submit" class="btn btn-default btn-danger" value="Отменить заявку"/>';
        echo '</form>';
    }

    ?>
</div>
