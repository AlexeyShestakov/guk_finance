<?php

namespace Guk\FinFormsPage;

class ControllerFinFormsPage
{
    public function finRequestPageAction($request_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_page.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    public function getFinFormsPageUrl(){
        return '/guk/finforms';
    }

    public function finFormsPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_forms_page.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    public function getFinFormPageUrl($form_id){
        return '/finform/' . $form_id;
    }

    public function finFormPageAction($form_id){

        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'set_value'){
                $row_id = $_POST['row_id'];
                $col_id = $_POST['col_id'];
                $value = $_POST['value'];

                $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_id, $col_id);
                //$request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($request_id, $row_id, $col_id);
                if ($cell_obj){
                    $cell_obj->setValue($value);
                    $cell_obj->save();
                } else {
                    $cell_obj = new \Guk\FinFormCell();
                    $cell_obj->setRowId($row_id);
                    $cell_obj->setColId($col_id);
                    $cell_obj->setValue($value);
                    $cell_obj->save();
                }
            }
        }


        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_form_page.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    public function finRequestsPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_requests_page.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }
}