<?php

namespace Guk\VuzPage;

class ControllerVuz
{
    public function vuzPageAction(){
        $vuz_id = 1; // TODO: get from account
        $content = \Cebera\Render\Render::callLocaltemplate("templates/vuz_page.tpl.php", array('vuz_id' => $vuz_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    public function finRequestAddAction(){
        $vuz_id = 1; // TODO: get from account

        if (array_key_exists('a', $_POST)) {
            if ($_POST['a'] == 'add_request') {
                $title = $_POST['title'];
                $fin_form_id = $_POST['fin_form_id'];

                $request_obj = new \Guk\FinRequest;
                $request_obj->setTitle($title);
                $request_obj->setVuzId($vuz_id);
                $request_obj->setCreatedAtTs(time());
                $request_obj->setFinFormId($fin_form_id);
                $request_obj->setStatusCode(\Guk\FinRequest::STATUS_DRAFT);

                $request_obj->save();

                \Cebera\Helpers::redirect('/vuz/finrequest/' . $request_obj->getId() . '/fill');
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_add.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    static public function getFinRequestEditUrl($request_id){
        return '/vuz/finrequest/' . $request_id;
    }

    public function finRequestEditAction($request_id){
        $vuz_id = 1; // TODO: get from account

        if (array_key_exists('a', $_POST)) {
            if ($_POST['a'] == 'edit_request') {
                $title = $_POST['title'];

                $request_obj = \Guk\FinRequest::factory($request_id);

                if ($request_obj->getStatusCode() != \Guk\FinRequest::STATUS_DRAFT){
                    throw new \Exception('Статус заявки запрещает ее редактирование.');
                }

                $request_obj->setTitle($title);
                $request_obj->save();

            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_edit.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    static public function getFinRequestFillUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/fill';
    }

    public function finRequestFillPageAction($request_id){
        //$vuz_id = 1; // TODO: get from account

        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'set_value'){
                $row_id = $_POST['row_id'];
                $col_id = $_POST['col_id'];
                $value = $_POST['value'];

                $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($request_id, $row_id, $col_id);
                if ($request_cell_obj){
                    $request_cell_obj->setValue($value);
                    $request_cell_obj->save();
                } else {
                    $request_cell_obj = new \Guk\FinRequestCell();
                    $request_cell_obj->setFinRequestId($request_id);
                    $request_cell_obj->setRowId($row_id);
                    $request_cell_obj->setColId($col_id);
                    $request_cell_obj->setValue($value);
                    $request_cell_obj->save();
                }
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_fill_page.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }
}