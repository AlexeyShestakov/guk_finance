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

<h1>Form <?php echo $form_obj->getComment(); ?></h1>

<table class="table table-bordered table-condensed">

    <?php

    echo '<tr>';
    echo '<th>-</th>';

    foreach ($col_ids_arr as $col_id){
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<th>' . $col_obj->getTitle() . '</th>';
    }

    echo '</tr>';

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

                echo '<td><b>';
                echo $cell_value;
                echo '</b></td>';
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
