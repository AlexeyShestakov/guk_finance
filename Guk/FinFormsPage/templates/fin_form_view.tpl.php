<?php
/*

$form_id

*/

$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormsPageUrl(); ?>">Формы</a>
    / <?php echo \Cebera\Helpers::replaceEmptyValue($form_obj->getComment()); ?></h1>

<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormPageUrl($form_obj->getId()); ?>">Поля</a></li>
    <li role="presentation"><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormParamsPageUrl($form_obj->getId()); ?>">Параметры</a></li>
    <li role="presentation" class="active"><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormViewUrl($form_obj->getId()); ?>">Просмотр</a></li>
</ul>

<div>&nbsp;</div>

<?php

$col_ids_arr = $form_obj->getColIdsArrByWeight();
$row_ids_arr = $form_obj->getRowIdsArrByWeight();

?>

<table class="table table-bordered table-condensed table-striped">

    <?php

    echo '<thead><tr>';
    echo '<th>-</th>';

    foreach ($col_ids_arr as $col_id) {
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<th>' . \Cebera\Helpers::replaceEmptyValue($col_obj->getTitle()) . '</th>';
    }

    echo '<th>Лимит</th>';

    echo '</tr></thead>';

    $max_row_weight = 0;
    $max_col_weight = 0;

    foreach ($row_ids_arr as $row_id) {
        $row_obj = \Guk\FinFormRow::factory($row_id);

        if ($row_obj->getWeight() > $max_row_weight) {
            $max_row_weight = $row_obj->getWeight();
        }

        echo '<tr>';
        echo '<td>' . \Cebera\Helpers::replaceEmptyValue($row_obj->getWeight()) . '</td>';

        foreach ($col_ids_arr as $col_id) {
            $col_obj = \Guk\FinFormCol::factory($col_id);

            if ($col_obj->getWeight() > $max_col_weight) {
                $max_col_weight = $col_obj->getWeight();
            }

            if ($col_obj->getIsEditableByVuz()) {
                echo '<td>для вуза</td>';
            } else {

                $cell_value = '';

                $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());
                if ($cell_obj) {
                    $cell_value = $cell_obj->getValue();
                }

                echo '<td>';
                echo $cell_value;
                echo '</td>';

            }

        }

        echo '<td>' . $row_obj->getLimit() . '</td>';
        echo '</tr>';
    }


    ?>

</table>
