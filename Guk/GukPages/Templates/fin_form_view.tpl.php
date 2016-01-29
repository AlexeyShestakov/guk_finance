<?php
/**
 * @var $form_id
 */

use Guk\Pages\Forms\FormsController;
use Cebera\BT;

$form_obj = \Guk\FinForm::factory($form_id);

echo BT::pageHeader_plain('<a href="' . FormsController::formsAction(1) . '">Формы</a> / ' . \Guk\Helpers::replaceEmptyString($form_obj->getComment()));

\Guk\Pages\Forms\FormTabsTemplate::render($form_id);

$col_ids_arr = $form_obj->getColIdsArrByWeight();
$row_ids_arr = $form_obj->getRowIdsArrByWeight();

?>

<table class="table table-bordered table-condensed table-striped">

    <?php

    echo '<thead><tr>';
    echo '<th style="text-align: center;">№</th>';

    foreach ($col_ids_arr as $col_id) {
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<th style="text-align: center;"><small>' . \Guk\Helpers::replaceEmptyString($col_obj->getTitle()) . '</small></th>';
    }

    echo '<th style="text-align: center;"><small>Лимит (тыс. руб.)</small></th>';

    echo '</tr></thead>';

    $max_row_weight = 0;
    $max_col_weight = 0;

    foreach ($row_ids_arr as $row_id) {
        $row_obj = \Guk\FinFormRow::factory($row_id);

        if ($row_obj->getWeight() > $max_row_weight) {
            $max_row_weight = $row_obj->getWeight();
        }

        echo '<tr>';
        echo '<td style="text-align: right;"><small>' . \Guk\Helpers::replaceEmptyString($row_obj->getWeight()) . '</small></td>';

        foreach ($col_ids_arr as $col_id) {
            $col_obj = \Guk\FinFormCol::factory($col_id);

            if ($col_obj->getWeight() > $max_col_weight) {
                $max_col_weight = $col_obj->getWeight();
            }

            if ($col_obj->getIsEditableByVuz()) {
                echo '<td style="text-align: center;"><small>-</small></td>';
            } else {

                $cell_value = '';

                $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());
                if ($cell_obj) {
                    $cell_value = $cell_obj->getValue();
                }

                echo '<td style="text-align: center;"><small>';
                echo $cell_value;
                echo '</small></td>';

            }

        }

        $limit_str = number_format ( floatval($row_obj->getLimit()), 0 , "." , " " );
        echo '<td style="text-align: right;"><small>' . $limit_str . '</small></td>';
        echo '</tr>';
    }


    ?>

</table>

<div>
    <button type="button" class="btn btn-default">Скачать файл xls</button>
</div>
