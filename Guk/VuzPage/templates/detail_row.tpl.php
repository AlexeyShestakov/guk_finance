<?php

/**
 * @var $detail_row_id
 */

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

    echo '<td>';
    echo '<form method="post" onsubmit="var detail_row_id = $(this).children(\'[name=detail_row_id]\').first().val(); var detail_column_id = $(this).children(\'[name=detail_column_id]\').first().val(); var detail_value = $(this).children(\'[name=detail_value]\').first().val(); saveDetail(detail_row_id, detail_column_id, detail_value); return false;">';
    echo '<input type="hidden" name="a" value="set_detail_value"/>';
    echo '<input type="hidden" name="detail_row_id" value="' . $detail_row_obj->getId() . '"/>';
    echo '<input type="hidden" name="detail_column_id" value="' . $detail_column_id . '"/>';
    echo '<input name="detail_value" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $detail_value . '"/></form>';
    echo '</td>';
}

echo '</tr>';
