<?php

namespace Guk\GukPages;

use Guk\Pages\Forms\FormsController;

class ControllerForms
{
    const OPERATION_CODE_EDIT_COL = 'OPERATION_CODE_EDIT_COL';
    const OPERATION_CODE_EDIT_ROW = 'OPERATION_CODE_EDIT_ROW';
    const OPERATION_CODE_DELETE_COL = 'OPERATION_CODE_DELETE_COL';
    const OPERATION_CODE_ADD_ROW = 'OPERATION_CODE_ADD_ROW';

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
        //$content = \Cebera\Render\Render::callLocaltemplate("Templates/fin_form_docs.tpl.php", array('form_id' => $form_id));
        ob_start();
        \Guk\Pages\Forms\FormDetails::render($form_id);
        $content = ob_get_clean();

        //echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
        \Guk\Pages\GukLayoutTemplate::render($content);
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

    static public function getFinFormColUrl($col_id){
        return '/guk/finformcol/' . $col_id;
    }

    public function finFormColAction($col_id){
        \Cebera\BT::matchOperation(self::OPERATION_CODE_EDIT_COL, function() use($col_id){self::editColOperation($col_id);});
        \Cebera\BT::matchOperation(self::OPERATION_CODE_DELETE_COL, function() use($col_id){self::deleteColOperation($col_id);});

        ob_start();
        \Guk\Pages\Forms\FormColTemplate::render($col_id);
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function deleteColOperation($col_id)
    {
        $col_obj = \Guk\FinFormCol::factory($col_id);
        $form_id = $col_obj->getFormId();

        $col_obj->delete();

        \OLOG\Helpers::redirect(FormsController::finFormPageAction(1, $form_id));
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

        $col_obj->setWeight(\Cebera\BT::getPostValue(\Guk\Pages\Forms\FormColTemplate::FIELD_NAME_WEIGHT));
        $col_obj->setTitle(\Cebera\BT::getPostValue(\Guk\Pages\Forms\FormColTemplate::FIELD_NAME_TITLE));
        $col_obj->setIsEditableByVuz($for_vuz);
        $col_obj->setIsRequestedSum($is_requested_sum);
        $col_obj->setVocabularyId(\Cebera\BT::getPostValue(\Guk\Pages\Forms\FormColTemplate::FIELD_NAME_VOCABULARY_ID));
        $col_obj->save();
    }

    static public function operationAddRow($form_id)
    {
        $weight = $_POST['weight'];

        $row_obj = new \Guk\FinFormRow();

        $row_obj->setFormId($form_id);
        $row_obj->setWeight($weight);

        $row_obj->save();

        \OLOG\Helpers::redirect(FormsController::finFormPageAction(1, $form_id));
    }


}