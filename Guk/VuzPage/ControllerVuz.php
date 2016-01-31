<?php

namespace Guk\VuzPage;

class ControllerVuz
{
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

        //$content = \Cebera\Render\Render::callLocaltemplate("templates/request_payments_page.tpl.php", array('vuz_id' => $vuz_id, 'request_id' => $request_id));
        ob_start();
        \Vuz\Pages\Requests\RequestPaymentsTemplate::render($vuz_id, $request_id);
        $content = ob_get_clean();

        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }

    static public function addPaymentToRequestUrl($request_id){
        return self::requestPaymentsPageUrl($request_id) . '?a=add_payment';
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
        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }

    static public function getFinRequestPrintUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/print';
    }

    public function finRequestPrintAction($request_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_print.tpl.php", array('request_id' => $request_id));
        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }

    static public function getFinRequestUploadUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/upload';
    }

    public function finRequestUploadAction($request_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_upload.tpl.php", array('request_id' => $request_id));
        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }

    /*
    static public function getFinRequestFillUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/fill';
    }
    */

    static public function getFinRequestHistoryUrl($request_id){
        return '/vuz/finrequest/' . $request_id . '/history';
    }

    public function finRequestHistoryAction($request_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_history.tpl.php", array('request_id' => $request_id));
        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }
}