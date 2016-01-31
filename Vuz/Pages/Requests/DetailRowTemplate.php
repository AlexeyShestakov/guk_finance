<?php

namespace Vuz\Pages\Requests;

class DetailRowTemplate
{
    static public function detail_row($detail_row_id){
        $detail_row_obj = \Guk\DetailRow::factory($detail_row_id);
        $request_id = $detail_row_obj->getRequestId();
        $request_obj = \Guk\FinRequest::factory($request_id);
        $form_id = $request_obj->getFinFormId();

        $detail_column_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormByWeight($form_id);

        echo '<tr>';
        foreach ($detail_column_ids_arr as $detail_column_id) {
            $detail_column_obj = \Guk\DetailColumn::factory($detail_column_id);

            $detail_value = '';
            $detail_cell_obj = \Guk\DetailCell::getObjForRowAndCol($detail_row_id, $detail_column_id);
            if ($detail_cell_obj) {
                $detail_value = $detail_cell_obj->getValue();
            }

            if ($detail_column_obj->getVocabularyId()){
                echo '<td style="cursor: pointer;" ';
                echo ' data-toggle="modal" ';
                echo ' data-operation_code="' . RequestsController::OPERATION_SET_DETAIL_TERM_ID . '" ';
                echo ' data-vocabulary_id="' . $detail_column_obj->getVocabularyId() . '" ';
                echo ' data-context="' . $detail_row_id . ',' . $detail_column_id . '"';
                echo ' data-target="#' . \Vuz\Pages\VuzLayoutTemplate::MODAL_SELECT_TERM . '">';
                echo '<div>' . $detail_value . '</div>';
                echo '</td>';
            } else {

                echo '<td>';
                echo '<form method="post" onsubmit="var detail_row_id = $(this).children(\'[name=detail_row_id]\').first().val(); var detail_column_id = $(this).children(\'[name=detail_column_id]\').first().val(); var detail_value = $(this).children(\'[name=detail_value]\').first().val(); saveDetail(detail_row_id, detail_column_id, detail_value); return false;">';
                echo '<input type="hidden" name="a" value="set_detail_value"/>';
                echo '<input type="hidden" name="detail_row_id" value="' . $detail_row_obj->getId() . '"/>';
                echo '<input type="hidden" name="detail_column_id" value="' . $detail_column_id . '"/>';
                echo '<input name="detail_value" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $detail_value . '"/></form>';
                echo '</td>';
            }
        }

        echo '</tr>';
    }
}