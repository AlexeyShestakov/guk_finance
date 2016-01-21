<?php

namespace Guk\VuzPage;

class ControllerPayments
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
}