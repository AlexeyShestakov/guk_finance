<?php
/*

$form_id

*/

$form_obj = \Guk\FinForm::factory($form_id);

$col_ids_arr = $form_obj->getColIdsArrByWeight();
$row_ids_arr = $form_obj->getRowIdsArrByWeight();

?>

<h1>Form <?php echo $form_obj->getComment(); ?></h1>

<table class="table">

    <?php

    echo '<tr>';
    echo '<td>-</td>';

    foreach ($col_ids_arr as $col_id){
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<td>' . $col_obj->getTitle() . '</td>';
    }

    echo '</tr>';

    foreach ($row_ids_arr as $row_id){
        $row_obj = \Guk\FinFormRow::factory($row_id);

        echo '<tr>';
        echo '<td>' . $row_obj->getId() . '</td>';

        foreach ($col_ids_arr as $col_id){
            $col_obj = \Guk\FinFormCol::factory($col_id);

            $cell_value = $row_obj->getId() . '-' . $col_obj->getId();
            $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());
            if ($cell_obj){
                $cell_value = $cell_obj->getValue();
            }

            echo '<td>' . $cell_value . '</td>';
        }

        echo '</tr>';
    }


    ?>

</table>

<h2>Cols</h2>

<table class="table">

    <?php


    foreach ($col_ids_arr as $col_id){
        $col_obj = \Guk\FinFormCol::factory($col_id);

        echo '<tr><td>' . $col_obj->getTitle() . '</td><td><a href="/finformcol/' . $col_obj->getId() . '">изменить</a></td></tr>';
    }
    ?>

</table>

<h2>Rows</h2>

<table class="table">

    <?php

    foreach ($row_ids_arr as $row_id){
        $row_obj = \Guk\FinFormRow::factory($row_id);

        echo '<tr><td>' . $row_obj->getId() . '</td><td><a href="/finformrow/' . $row_obj->getId() . '">изменить</a></td></tr>';
    }

    ?>

</table>

