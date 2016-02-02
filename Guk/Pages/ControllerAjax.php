<?php

namespace Guk\Pages;

use Cebera\BT;

class ControllerAjax
{
    const OPERATION_UPDATE_FORM_CELL = 'OPERATION_UPDATE_FORM_CELL';
    const OPERATION_UPDATE_FORM_CELL_TERM = 'OPERATION_UPDATE_FORM_CELL_TERM';

    static public function ajaxAction($mode, $operation_code){
        $self_url = '/guk/ajax/' . $operation_code;
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        if ($operation_code == self::OPERATION_UPDATE_FORM_CELL){
            $pk = BT::getPostValue('pk');
            $value = BT::getPostValue('value');

            list($row_id, $col_id) = explode(',', $pk);

            $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_id, $col_id);
            if ($cell_obj) {
                $cell_obj->setValue($value);
                $cell_obj->save();
            } else {
                $cell_obj = new \Guk\FinFormCell();
                $cell_obj->setRowId($row_id);
                $cell_obj->setColId($col_id);
                $cell_obj->setValue($value);
                $cell_obj->save();
            }

            //\OLOG\Helpers::redirect(\Guk\Pages\Forms\FormsController::formAction(1, $form_id));

            \OLOG\Helpers::doJsonResponse(null);
        }

        if ($operation_code == self::OPERATION_UPDATE_FORM_CELL_TERM){
            $pk = BT::getPostValue('pk');
            $term_id = BT::getPostValue('value');

            list($row_id, $col_id) = explode(',', $pk);

            $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_id, $col_id);
            if ($cell_obj) {
                $cell_obj->setTermId($term_id);
                $cell_obj->save();
            } else {
                $cell_obj = new \Guk\FinFormCell();
                $cell_obj->setRowId($row_id);
                $cell_obj->setColId($col_id);
                $cell_obj->setTermId($term_id);
                $cell_obj->save();
            }

            //\OLOG\Helpers::redirect(\Guk\Pages\Forms\FormsController::formAction(1, $form_id));

            \OLOG\Helpers::doJsonResponse(null);
        }

    }
}