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

<h1><a href="/vuz">Заявки</a> / <?php echo \Guk\Helpers::replaceEmptyString($request_obj->getTitle()); ?></h1>

<?php \Vuz\Pages\Requests\RequestTabs::render($request_id); ?>

<div>&nbsp;</div>

<?php

if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_IN_GUK_REWIEW){
    echo '<div class="alert alert-info" role="alert">Заявка находится на утверждении в ГУК, изменение данных запрещено.</div>';
}

?>

<table class="table table-bordered table-condensed">

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
        $cols_count = 0;

        $row_obj = \Guk\FinFormRow::factory($row_id);

        echo '<tr>';
        echo '<td>' . $row_obj->getId() . '</td>';
        $cols_count++;

        foreach ($col_ids_arr as $col_id){
            $col_obj = \Guk\FinFormCol::factory($col_id);

            if ($col_obj->getIsEditableByVuz()){
                $cell_value = '';

                $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($request_id, $row_id, $col_id);
                if ($request_cell_obj){
                    $cell_value = $request_cell_obj->getValue();
                }

                echo '<td>';

                if (in_array($request_obj->getStatusCode(), array( \Guk\FinRequest::STATUS_DRAFT, \Guk\FinRequest::STATUS_REJECTED_BY_GUK ))){
                    echo '<form method="post" action="' . \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()) . '">';
                    echo '<input type="hidden" name="a" value="set_value"/>';
                    echo '<input type="hidden" name="row_id" value="' . $row_obj->getId() . '"/>';
                    echo '<input type="hidden" name="col_id" value="' . $col_obj->getId() . '"/>';
                    echo '<input name="value" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $cell_value . '"/></form>';
                } else {
                    echo $cell_value;
                }


                echo '</td>';
                $cols_count++;
            } else {
                $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());

                if ($cell_obj){
                    echo '<td style="text-align: center;"><small>' . $cell_obj->getValue() . '</small></td>';
                    $cols_count++;
                } else {
                    echo '<td></td>';
                    $cols_count++;
                }

            }

        }

        $row_extras_htmlid = 'request_' . $request_id . '_row_' . $row_obj->getId() . '_extras';

        echo '<td style="text-align: center;"><small><a href="#" class="glyphicon glyphicon-tasks" onclick="$(\'#' . $row_extras_htmlid  . '\').slideToggle(0); return false;"></a></small></td>';
        $cols_count++;

        echo '</tr>';

        $details_table_htmlid = 'request_' . $request_id . '_details_table_for_row_' . $row_obj->getId();

        echo '<tr style="display: none;" id="' . $row_extras_htmlid . '">';
        echo '<td style="background-color: #ddd;" colspan="' . $cols_count . '">';
        echo '<table id="' . $details_table_htmlid . '"  class="table table-bordered table-condensed">';
        echo '<thead><tr>';
        /*
        echo '<th><small>Наименование расходов (услуги, закупки, работы)</small></th>';
        echo '<th><small>Ед. изм.</small></th>';
        echo '<th><small>Потребность</small></th>';
        echo '<th><small>Примерная стоимость за единицу (тыс. руб.)</small></th>';
        echo '<th><small>Общая стоимость (тыс. руб.)</small></th>';
        echo '<th><small>Ожидаемый результат и краткое обоснование</small></th>';
        */

        $detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormById($form_id);
        foreach ($detail_column_ids_arr as $detail_column_id){
            $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);
            echo '<th class="text-center"><small>' . $detail_column_obj->getTitle() . '</small></th>';
        }

        echo '</thead>';

        $detail_row_ids_arr = \Guk\DetailRow::getDetailRowIdsArrForRequestAndFormRowById($request_id, $row_id);
        foreach ($detail_row_ids_arr as $detail_row_id){
            echo \Cebera\Render\Render::callLocaltemplate('detail_row.tpl.php', array("detail_row_id" => $detail_row_id));
        }

        echo '</table>';

        echo '<div><button class="btn btn-default btn-sm" onclick="append_detail(\'' . $request_id . '\', \'' . $row_obj->getId() . '\', \'' . $details_table_htmlid . '\');">Добавить строку обоснования</button></div>';
        echo '</td></tr>';
    }


    ?>

</table>

<div>

    <?php

    if (in_array($request_obj->getStatusCode(), array( \Guk\FinRequest::STATUS_DRAFT, \Guk\FinRequest::STATUS_REJECTED_BY_GUK ))){
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

<script>

    function append_detail(request_id, form_row_id, details_table_htmlid){
        var context_obj = {details_table_htmlid: details_table_htmlid};

        $.ajax({
                method: "POST",
                url: "<?= \Guk\VuzPage\ControllerAjax::appendDetailUrl(); ?>",
                data: { a: "add_detail_row", request_id: request_id, form_row_id: form_row_id },
                context: context_obj
            })
            .done(function( new_row_html ) {
                //alert( "Got data: " + msg );
                //alert(this.details_table_htmlid);
                $('#' + this.details_table_htmlid).append(new_row_html);
            });
    }

    function saveDetail(detail_row_id, detail_column_id, detail_value){
        $.ajax({
                method: "POST",
                url: "<?= \Guk\VuzPage\ControllerAjax::saveDetailUrl(); ?>",
                data: { a: "save_detail", detail_row_id: detail_row_id, detail_column_id: detail_column_id, detail_value: detail_value }
            })
            .done(function( new_row_html ) {
            });
    }

</script>