<?php

namespace Guk\GukPages;

class ControllerForms
{
    const EDIT_COL_OPERATION_CODE = 'edit_col';
    const EDIT_ROW_OPERATION_CODE = 'edit_row';

    public function kbkReportAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("Templates/kbk_report.tpl.php");
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

        $content = \Cebera\Render\Render::callLocaltemplate("Templates/fin_form_params.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function docsUrl($form_id){
        return '/guk/finform/' . $form_id . '/docs';
    }

    public function docsAction($form_id){
        $content = \Cebera\Render\Render::callLocaltemplate("Templates/fin_form_docs.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function archiveUrl($form_id){
        return '/guk/finform/' . $form_id . '/archive';
    }

    public function archiveAction($form_id){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'hide_form'){
                $form_obj = \Guk\FinForm::factory($form_id);

                $form_obj->setIsHidden(1);
                $form_obj->save();
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("Templates/form_archive.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function historyUrl($form_id){
        return '/guk/finform/' . $form_id . '/history';
    }

    public function historyAction($form_id){
        $content = \Cebera\Render\Render::callLocaltemplate("Templates/form_history.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormViewUrl($form_id){
        return '/guk/finform/' . $form_id . '/view';
    }

    public function finFormViewAction($form_id){
        $content = \Cebera\Render\Render::callLocaltemplate("Templates/fin_form_view.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinFormRowUrl($row_id){
        return '/guk/finformrow/' . $row_id;
    }

    public function finFormRowAction($row_id){
        \Cebera\BT::matchOperation(self::EDIT_ROW_OPERATION_CODE, function() use($row_id){self::editRowOperation($row_id);});

        if (isset($_GET['a'])){
            if ($_GET['a'] == 'add_term'){
                $row_term_obj = new \Guk\FormRowTermId();

                $row_term_obj->setFormRowId($row_id);
                $row_term_obj->setTermId($_GET['term_id']);

                $row_term_obj->save();
            }
        }

        ob_start();
        \Guk\GukPages\Templates\FormRowTemplate::render($row_id);
        $content = ob_get_clean();

        \Guk\GukPages\Templates\GukLayoutTemplate::render($content);
    }

    static public function editRowOperation($row_id)
    {
        $row_obj = \Guk\FinFormRow::factory($row_id);

        $row_obj->setWeight(\Cebera\BT::getPostValue('weight'));
        $row_obj->setLimit(\Cebera\BT::getPostValue('limit'));
        $row_obj->setKbk(\Cebera\BT::getPostValue('kbk'));

        $row_obj->save();
    }

    static public function getFinFormColUrl($col_id){
        return '/guk/finformcol/' . $col_id;
    }

    public function finFormColAction($col_id){
        \Cebera\BT::matchOperation(self::EDIT_COL_OPERATION_CODE, function() use($col_id){self::editColOperation($col_id);});

        ob_start();
        \Guk\GukPages\Templates\FormColTemplate::render($col_id);
        $content = ob_get_clean();

        \Guk\GukPages\Templates\GukLayoutTemplate::render($content);
    }

    static public function editColOperation($col_id)
    {
        $for_vuz = 0;
        if (array_key_exists('for_vuz', $_POST)) {
            $for_vuz = 1;
        }

        $is_requested_sum = 0;
        if (array_key_exists('is_requested_sum', $_POST)) {
            $is_requested_sum = 1;
        }

        $col_obj = \Guk\FinFormCol::factory($col_id);

        $col_obj->setWeight(\Cebera\BT::getPostValue(\Guk\GukPages\Templates\FormColTemplate::FIELD_NAME_WEIGHT));
        $col_obj->setTitle(\Cebera\BT::getPostValue(\Guk\GukPages\Templates\FormColTemplate::FIELD_NAME_TITLE));
        $col_obj->setIsEditableByVuz($for_vuz);
        $col_obj->setIsRequestedSum($is_requested_sum);
        $col_obj->setVocabularyId(\Cebera\BT::getPostValue(\Guk\GukPages\Templates\FormColTemplate::FIELD_NAME_VOCABULARY_ID));
        $col_obj->save();
    }

    static public function getFinFormsPageUrl(){
        return '/guk/forms';
    }

    public function finFormsPageAction(){
        ob_start();
        \Guk\GukPages\Templates\FormsTemplate::render();
        $content = ob_get_clean();
        \Guk\GukPages\Templates\GukLayoutTemplate::render($content);
    }

    static public function formUrl($form_id){
        return '/guk/form/' . $form_id;
    }

    static public function getFinFormAddPageUrl(){
        return '/guk/form';
    }

    public function finFormAddAction(){
        if (array_key_exists('a', $_POST)) {
            if ($_POST['a'] == 'add_form') {
                $form_obj = new \Guk\FinForm();
                $form_obj->setComment(\Cebera\BT::getPostValue('comment'));
                $form_obj->setCreatedAtTs(time());
                $form_obj->save();

                \Cebera\Helpers::redirect(self::formUrl($form_obj->getId()));
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("Templates/fin_form_add.tpl.php");
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

        ob_start();
        \Guk\GukPages\Templates\FormPageTemplate::render($form_id);
        $content = ob_get_clean();

        \Guk\GukPages\Templates\GukLayoutTemplate::render($content);
    }

}