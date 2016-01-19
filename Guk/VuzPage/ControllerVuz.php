<?php

namespace Guk\VuzPage;

class ControllerVuz
{
    static public function paymentsPageUrl(){
        return '/vuz/payments';
    }

    public function paymentsPageAction(){
        $vuz_id = 1; // TODO: get from account
        $content = \Cebera\Render\Render::callLocaltemplate("templates/payments_page.tpl.php", array('vuz_id' => $vuz_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    static public function paymentUrl($payment_id){
        return '/vuz/payment/' . $payment_id;
    }

    public function paymentPageAction($payment_id){
        $vuz_id = 1; // TODO: get from account

        if (array_key_exists('a', $_POST)) {
            if ($_POST['a'] == 'set_payment_status_code') {
                $status_code = $_POST['status_code'];
                //$comment = $_POST['comment'];
                $payment_obj = \Guk\VuzPayment::factory($payment_id);

                //$old_status_code = $request_obj->getStatusCode();

                $payment_obj->setStatusCode($status_code);
                $payment_obj->save();

                /*
                $request_obj->logChange(
                    'ГУК изменил статус заявки с "' . \Guk\FinRequest::getStatusStrForCode($old_status_code) . '" на "' . \Guk\FinRequest::getStatusStrForCode($status_code) . '"".',
                    $comment
                );
                */
            }
        }


        $content = \Cebera\Render\Render::callLocaltemplate("templates/payment_page.tpl.php", array('payment_id' => $payment_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    static public function requestPaymentsPageUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/payments';
    }

    public function requestPaymentsPageAction($request_id){
        $vuz_id = 1; // TODO: get from account

        if (array_key_exists('a', $_GET)) {
            if ($_GET['a'] == 'add_payment') {
                $payment_obj = new \Guk\VuzPayment();
                $payment_obj->setTitle('Новый платеж');
                $payment_obj->setVuzId($vuz_id);
                $payment_obj->setCreatedAtTs(time());
                $payment_obj->setRequestId($request_id);

                $payment_obj->save();

                //\Cebera\Helpers::redirect('/vuz/finrequest/' . $request_obj->getId() . '/fill');
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/request_payments_page.tpl.php", array('vuz_id' => $vuz_id, 'request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    static public function addPaymentToRequestUrl($request_id){
        return self::requestPaymentsPageUrl($request_id) . '?a=add_payment';
    }

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

    static public function getFinRequestPrintUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/print';
    }

    public function finRequestPrintAction($request_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_print.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    static public function getFinRequestUploadUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/upload';
    }

    public function finRequestUploadAction($request_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_upload.tpl.php", array('request_id' => $request_id));
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

            if ($_POST['a'] == 'set_request_status_code'){

                $status_code = $_POST['status_code'];
                $request_obj = \Guk\FinRequest::factory($request_id);

                $old_status_code = $request_obj->getStatusCode();

                $request_obj->setStatusCode($status_code);
                $request_obj->save();

                $request_obj->logChange('ВУЗ изменил статус заявки с "' . \Guk\FinRequest::getStatusStrForCode($old_status_code) . '" на "' . \Guk\FinRequest::getStatusStrForCode($status_code) . '"".');
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_fill_page.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }

    static public function getFinRequestHistoryUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/history';
    }

    public function finRequestHistoryAction($request_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_history.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../vuz_layout.tpl.php", array('content' => $content));
    }
}