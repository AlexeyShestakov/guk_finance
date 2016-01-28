<?php

namespace Guk\Pages\Forms;

use Guk\GukPages\ControllerForms;

class FormsController
{
    const ADD_FORM_OPERATION_CODE = 'ADD_FORM_OPERATION_CODE';
    const OPERATION_CODE_EDIT_CELL = 'OPERATION_CODE_EDIT_CELL';
    const OPERATION_CODE_DELETE_ROW = 'OPERATION_CODE_DELETE_ROW';
    const OPERATION_CODE_REMOVE_ROW_TERM = 'OPERATION_CODE_REMOVE_ROW_TERM';

    public static function formsAction($mode)
    {
        $self_url = '/guk/forms';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        \Cebera\BT::matchOperation(self::ADD_FORM_OPERATION_CODE, function() {self::addFormOperation();});

        ob_start();
        \Guk\Pages\Forms\FormsTemplate::render();
        $content = ob_get_clean();
        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function addFormOperation(){
        $form_obj = new \Guk\FinForm();
        $form_obj->setComment(\Cebera\BT::getPostValue(\Guk\Pages\Forms\FormsTemplate::FIELD_NAME_FORM_TITLE));
        $form_obj->setCreatedAtTs(time());
        $form_obj->save();

        \OLOG\Helpers::redirect(FormsController::finFormPageAction(1, $form_obj->getId()));
    }

    public static function finFormPageAction($mode, $form_id)
    {
        $self_url = '/guk/form/' . $form_id;
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        \Cebera\BT::matchOperation(self::OPERATION_CODE_EDIT_CELL, function() use ($form_id){self::operationEditFormCell($form_id);});

        if (array_key_exists('a', $_POST)) {

            if ($_POST['a'] == 'add_col') {
                $weight = $_POST['weight'];

                $col_obj = new \Guk\FinFormCol();

                $col_obj->setFormId($form_id);
                $col_obj->setWeight($weight);

                $col_obj->save();
            }
        }

        \Cebera\BT::matchOperation(ControllerForms::OPERATION_CODE_ADD_ROW, function () use ($form_id) {
            ControllerForms::operationAddRow($form_id);
        });

        ob_start();
        \Guk\GukPages\Templates\FormTemplate::render($form_id);
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function operationEditFormCell($form_id)
    {
        $row_id = \Cebera\BT::getPostValue(\Guk\GukPages\Templates\FormTemplate::FIELD_NAME_ROW_ID);
        $col_id = \Cebera\BT::getPostValue(\Guk\GukPages\Templates\FormTemplate::FIELD_NAME_COL_ID);
        $value = \Cebera\BT::getPostValue(\Guk\GukPages\Templates\FormTemplate::FIELD_NAME_CELL_VALUE);

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

        \OLOG\Helpers::redirect(\Guk\Pages\Forms\FormsController::finFormPageAction(1, $form_id));
    }

    public static function finFormRowAction($mode, $row_id)
    {
        $self_url = '/guk/finformrow/' . $row_id;
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        \Cebera\BT::matchOperation(ControllerForms::OPERATION_CODE_EDIT_ROW, function () use ($row_id) {self::editRowOperation($row_id);});
        \Cebera\BT::matchOperation(self::OPERATION_CODE_DELETE_ROW, function () use ($row_id) {self::deleteRowOperation($row_id);});
        \Cebera\BT::matchOperation(self::OPERATION_CODE_REMOVE_ROW_TERM, function() use ($row_id) {self::deleteRowTermOperation($row_id);});

        if (isset($_GET['a'])) {
            if ($_GET['a'] == 'add_term') {
                $row_term_obj = new \Guk\FormRowToTerm();

                $row_term_obj->setFormRowId($row_id);
                $row_term_obj->setTermId($_GET['term_id']);

                $row_term_obj->save();
            }
        }

        ob_start();
        \Guk\Pages\Forms\FormRowTemplate::render($row_id);
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function editRowOperation($row_id)
    {
        $row_obj = \Guk\FinFormRow::factory($row_id);

        $row_obj->setWeight(\Cebera\BT::getPostValue('weight'));
        $row_obj->setLimit(\Cebera\BT::getPostValue('limit'));
        $row_obj->setKbk(\Cebera\BT::getPostValue('kbk'));

        $row_obj->save();
    }

    static public function deleteRowOperation($row_id)
    {
        $row_obj = \Guk\FinFormRow::factory($row_id);
        $form_id = $row_obj->getFormId();

        $row_obj->delete();

        \OLOG\Helpers::redirect(\Guk\Pages\Forms\FormsController::finFormPageAction(1, $form_id));
    }

    static public function deleteRowTermOperation($row_id)
    {
        //$row_obj = \Guk\FinFormRow::factory($row_id);
        //$form_id = $row_obj->getFormId();
        $row_to_term_id = \Cebera\BT::getPostValue(FormRowTemplate::FIELD_NAME_ROW_TO_TERM_ID);
        $row_to_term_obj = \Guk\FormRowToTerm::factory($row_to_term_id);
        $row_to_term_obj->delete();

        \OLOG\Helpers::redirect(FormsController::finFormRowAction(1, $row_id));
    }


}