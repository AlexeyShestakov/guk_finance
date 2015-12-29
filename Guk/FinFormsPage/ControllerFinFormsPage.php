<?php

namespace Guk\FinFormsPage;

class ControllerFinFormsPage
{
    public function kbkReportAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/kbk_report.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormParamsPageUrl($form_id){
        return '/guk/finform/' . $form_id . '/params';
    }

    public function finFormParamsAction($form_id){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'edit_form'){
                $comment = $_POST['comment'];
                $is_current = 0;
                if (array_key_exists('is_current', $_POST)) {
                    $is_current = 1;
                }

                $form_obj = \Guk\FinForm::factory($form_id);

                $form_obj->setComment($comment);
                $form_obj->setIsCurrent($is_current);
                $form_obj->save();
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_form_params.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormViewUrl($form_id){
        return '/guk/finform/' . $form_id . '/view';
    }

    public function finFormViewAction($form_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_form_view.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormRowUrl($row_id){
        return '/guk/finformrow/' . $row_id;
    }

    public function finFormRowAction($row_id){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'edit_row'){
                $weight = $_POST['weight'];
                $limit = $_POST['limit'];
                $kbk = $_POST['kbk'];

                $row_obj = \Guk\FinFormRow::factory($row_id);

                $row_obj->setWeight($weight);
                $row_obj->setLimit($limit);
                $row_obj->setKbk($kbk);
                $row_obj->save();
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_form_row.tpl.php", array('row_id' => $row_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormColUrl($col_id){
        return '/guk/finformcol/' . $col_id;
    }

    public function finFormColAction($col_id){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'edit_col'){
                $weight = $_POST['weight'];
                $title = $_POST['title'];

                $for_vuz = 0;
                if (array_key_exists('for_vuz', $_POST)) {
                    $for_vuz = 1;
                }

                $is_requested_sum = 0;
                if (array_key_exists('is_requested_sum', $_POST)) {
                    $is_requested_sum = 1;
                }

                $col_obj = \Guk\FinFormCol::factory($col_id);

                $col_obj->setWeight($weight);
                $col_obj->setTitle($title);
                $col_obj->setIsEditableByVuz($for_vuz);
                $col_obj->setIsRequestedSum($is_requested_sum);
                $col_obj->save();
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_form_col.tpl.php", array('col_id' => $col_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    public function getFinRequestUrl($request_id){
        return '/guk/finrequest/' . $request_id;
    }

    public function finRequestPageAction($request_id){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'set_request_status_code'){
                $status_code = $_POST['status_code'];
                $comment = $_POST['comment'];
                $request_obj = \Guk\FinRequest::factory($request_id);

                $old_status_code = $request_obj->getStatusCode();

                $request_obj->setStatusCode($status_code);
                $request_obj->save();

                $request_obj->logChange(
                    'ГУК изменил статус заявки с "' . \Guk\FinRequest::getStatusStrForCode($old_status_code) . '" на "' . \Guk\FinRequest::getStatusStrForCode($status_code) . '"".',
                    $comment
                );
            }

            if ($_POST['a'] == 'set_request_cell_value'){
                $request_cell_id = $_POST['request_cell_id'];
                $value = $_POST['value'];
                $comment = $_POST['comment'];
                $request_cell_obj = \Guk\FinRequestCell::factory($request_cell_id);

                $old_cell_value = $request_cell_obj->getValue();

                $request_cell_obj->setValue($value);
                $request_cell_obj->save();

                $request_obj = \Guk\FinRequest::factory($request_id);
                $row_id = $request_cell_obj->getRowId();
                $row_obj = \Guk\FinFormRow::factory($row_id);

                $request_obj->logChange(
                    'ГУК изменил значение поля заявки с "' . $old_cell_value . '" на "' . $value . '"" в строке "' . $row_obj->getWeight() . '".',
                    $comment
                );
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_page.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormsPageUrl(){
        return '/guk/finforms';
    }

    public function finFormsPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_forms_page.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormPageUrl($form_id){
        return '/finform/' . $form_id;
    }

    static public function getFinFormAddPageUrl(){
        return '/guk/finform';
    }

    public function finFormAddAction(){
        if (array_key_exists('a', $_POST)) {
            if ($_POST['a'] == 'add_form') {
                $comment = $_POST['comment'];

                $form_obj = new \Guk\FinForm();
                $form_obj->setComment($comment);
                $form_obj->setCreatedAtTs(time());
                $form_obj->save();

                \Cebera\Helpers::redirect(self::getFinFormPageUrl($form_obj->getId()));
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_form_add.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
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

            if ($_POST['a'] == 'add_row'){
                $weight = $_POST['weight'];

                $row_obj = new \Guk\FinFormRow();

                $row_obj->setFormId($form_id);
                $row_obj->setWeight($weight);

                $row_obj->save();
            }

            if ($_POST['a'] == 'add_col'){
                $weight = $_POST['weight'];

                $col_obj = new \Guk\FinFormCol();

                $col_obj->setFormId($form_id);
                $col_obj->setWeight($weight);

                $col_obj->save();
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_form_page.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinRequestsUrl(){
        return '/guk/requests';
    }

    public function finRequestsPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_requests_page.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }
}