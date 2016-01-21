<?php
/**
 * @var $request_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);
$form_id = $request_obj->getFinFormId();

$form_obj = \Guk\FinForm::factory($form_id);

$col_ids_arr = $form_obj->getColIdsArrByWeight();
$row_ids_arr = $form_obj->getRowIdsArrByWeight();

$detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrById();
$detail_columns_count = count($detail_column_ids_arr);


?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($request_obj->getTitle()); ?></h1>

<?php echo \Cebera\Render\Render::callLocaltemplate('request_tabs.tpl.php', array("request_id" => $request_id)); ?>

<div>&nbsp;</div>

<div><button class="btn btn-default">Скачать файл Excel для печати</button></div>

<div>&nbsp;</div>

<h2 class="text-center">ФИНАНСОВО-ЭКОНОМИЧЕСКОЕ ОБОСНОВАНИЕ</h2>

<table class="table table-bordered table-condensed">

    <?php

    echo '<thead><tr>';
    /*
    echo '<th><small>Наименование расходов (услуги, закупки, работы)</small></th>';
    echo '<th><small>Ед. изм.</small></th>';
    echo '<th><small>Потребность</small></th>';
    echo '<th><small>Примерная стоимость за единицу (тыс. руб.)</small></th>';
    echo '<th><small>Общая стоимость (тыс. руб.)</small></th>';
    echo '<th><small>Ожидаемый результат и краткое обоснование</small></th>';
    */

    foreach ($detail_column_ids_arr as $detail_column_id){
        $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);
        echo '<th class="text-center"><small>' . $detail_column_obj->getTitle() . '</small></th>';
    }

    echo '</tr></thead>';

    $total_sum = 0;

    foreach ($row_ids_arr as $row_id){
        $cols_count = 0;

        $row_obj = \Guk\FinFormRow::factory($row_id);

        echo '<tr>';
        echo '<td style="padding-top: 30px;" class="text-center" colspan="' . $detail_columns_count . '"><b>Мероприятия, подлежащие финансированию по КОСГУ ' . $row_obj->getId() . '</b></td>';
        echo '</tr>';

        $kosgu_sum = 0;

        $detail_row_ids_arr = \Guk\DetailRow::getDetailRowIdsArrForRequestAndFormRowById($request_id, $row_id);
        foreach ($detail_row_ids_arr as $detail_row_id){
            $detail_row_obj = \Guk\DetailRow::factory($detail_row_id);

            $detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrById();

            echo '<tr>';
            foreach ($detail_column_ids_arr as $detail_column_id) {
                $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);

                $detail_value = '';
                $detail_cell_obj = \Guk\DetailCell::getObjForRowAndCol($detail_row_id, $detail_column_id);
                if ($detail_cell_obj) {
                    $detail_value = $detail_cell_obj->getValue();
                }

                if ($detail_column_obj->getIsRequestedSum()) {
                    echo '<td class="text-right"><small>' . $detail_value . '</small></td>';
                    $kosgu_sum += intval($detail_value);
                    $total_sum += intval($detail_value);
                } else {
                    echo '<td><small>' . $detail_value . '</small></td>';

                }
            }
            echo '</tr>';
        }

        echo '<tr>';
        foreach ($detail_column_ids_arr as $detail_column_id) {
            $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);

            if ($detail_column_obj->getIsRequestedSum()) {
                echo '<td class="text-right"><small><b>Итого: ' . $kosgu_sum . '</b></small></td>';
            } else {
                echo '<td></td>';
            }
        }
        echo '</tr>';
    }

    echo '<tr>';
    foreach ($detail_column_ids_arr as $detail_column_id) {
        $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);

        if ($detail_column_obj->getIsRequestedSum()) {
            echo '<td class="text-right"><small><b>Всего: ' . $total_sum . '</b></small></td>';
        } else {
            echo '<td></td>';
        }
    }
    echo '</tr>';

    ?>

</table>
