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
    <li role="presentation"><a href="#">Обоснование</a></li>
</ul>

<table class="table table-bordered table-condensed">

    <?php

    echo '<thead><tr>';
    echo '<th>-</th>';

    foreach ($col_ids_arr as $col_id){
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<th><small>' . $col_obj->getTitle() . '</small></th>';
    }

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
                echo '<form method="post" action="/vuz/finrequest/' . $request_obj->getId() . '/fill">';
                echo '<input type="hidden" name="a" value="set_value"/>';
                echo '<input type="hidden" name="row_id" value="' . $row_obj->getId() . '"/>';
                echo '<input type="hidden" name="col_id" value="' . $col_obj->getId() . '"/>';
                echo '<input name="value" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $cell_value . '"/></form>';
                echo '</td>';
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

        echo '</tr>';
    }


    ?>

</table>
