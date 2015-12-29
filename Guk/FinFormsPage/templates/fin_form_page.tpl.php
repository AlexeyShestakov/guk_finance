<?php
/*

$form_id

*/

$form_obj = \Guk\FinForm::factory($form_id);

$col_ids_arr = $form_obj->getColIdsArrByWeight();
$row_ids_arr = $form_obj->getRowIdsArrByWeight();

?>

<h1><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormsPageUrl(); ?>">Формы</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($form_obj->getComment()); ?></h1>

<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormPageUrl($form_obj->getId()); ?>">Поля</a></li>
    <li role="presentation"><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormParamsPageUrl($form_obj->getId()); ?>">Параметры</a></li>
</ul>

<div>&nbsp;</div>

<table class="table table-bordered table-condensed">

    <?php

    echo '<thead><tr>';
    echo '<th>-</th>';

    foreach ($col_ids_arr as $col_id){
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<th><a href="/finformcol/' . $col_obj->getId() . '">' . \Cebera\Helpers::replaceEmptyValue($col_obj->getTitle()) . '</a></sup></th>';
    }

    echo '<th>Лимит</th>';

    echo '</tr></thead>';

    foreach ($row_ids_arr as $row_id){
        $row_obj = \Guk\FinFormRow::factory($row_id);

        echo '<tr>';
        echo '<td><a href="/finformrow/' . $row_obj->getId() . '">' . \Cebera\Helpers::replaceEmptyValue($row_obj->getId()) . '</a></td>';

        foreach ($col_ids_arr as $col_id){
            $col_obj = \Guk\FinFormCol::factory($col_id);

            if ($col_obj->getIsEditableByVuz()){
                echo '<td>для вуза</td>';
            } else {

                $cell_value = '';

                $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());
                if ($cell_obj){
                    $cell_value = $cell_obj->getValue();
                }

                echo '<td>';
                echo '<form method="post" action="' . \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormPageUrl($form_obj->getId()) . '">';
                echo '<input type="hidden" name="a" value="set_value"/>';
                echo '<input type="hidden" name="row_id" value="' . $row_obj->getId() . '"/>';
                echo '<input type="hidden" name="col_id" value="' . $col_obj->getId() . '"/>';
                echo '<input name="value" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $cell_value . '"/></form>';
                echo '</td>';

            }

        }

        echo '<td>' . $row_obj->getLimit() . '</td>';
        echo '</tr>';
    }


    ?>

</table>

<div>
    <a href="" class="btn btn-default" role="button">Добавить строку</a>
    <a href="" class="btn btn-default" role="button">Добавить колонку</a>
</div>
