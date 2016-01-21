<?php

namespace Guk\VuzPage;

class ControllerAjax
{
    static public function appendDetailUrl(){
        return '/ajax/append_detail';
    }

    public function appendDetailAction()
    {
        if (isset($_POST['a'])) {
            if ($_POST['a'] == 'add_detail_row') {
                $request_id = $_POST['request_id'];
                $form_row_id = $_POST['form_row_id'];

                $detail_row_obj = new \Guk\DetailRow();
                $detail_row_obj->setRequestId($request_id);
                $detail_row_obj->setFormRowId($form_row_id);
                $detail_row_obj->save();

                echo \Cebera\Render\Render::callLocaltemplate('templates/detail_row.tpl.php', array('detail_row_id' => $detail_row_obj->getId()));

            }
        }
    }

    static public function saveDetailUrl(){
        return '/ajax/save_detail';
    }

    public function saveDetailAction()
    {
        if (isset($_POST['a'])) {
            if ($_POST['a'] == 'save_detail') {
                $detail_row_id = $_POST['detail_row_id'];
                $detail_column_id = $_POST['detail_column_id'];
                $detail_value = $_POST['detail_value'];

                $detail_cell_obj = \Guk\DetailCell::getObjForRowAndCol($detail_row_id, $detail_column_id);
                if (!$detail_cell_obj){
                    $detail_cell_obj = new \Guk\DetailCell();
                    $detail_cell_obj->setDetailColumnId($detail_column_id);
                    $detail_cell_obj->setDetailRowId($detail_row_id);
                }

                $detail_cell_obj->setValue($detail_value);
                $detail_cell_obj->save();
            }
        }
    }
}