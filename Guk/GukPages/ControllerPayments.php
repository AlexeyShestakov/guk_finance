<?php

namespace Guk\GukPages;

class ControllerPayments
{
    static public function paymentsUrl(){
        return '/guk/payments';
    }

    public function paymentsAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/payments.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }


    static public function paymentUrl($payment_id){
        return '/guk/payments/' . $payment_id;
    }

    public function paymentAction($payment_id){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'set_payment_status_code'){
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

            if ($_POST['a'] == 'edit_payment'){
                $title = $_POST['title'];
                $amount_rub = $_POST['amount_rub'];

                $payment_obj = \Guk\VuzPayment::factory($payment_id);

                $payment_obj->setTitle($title);
                $payment_obj->setAmountRub($amount_rub);
                $payment_obj->save();
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/payment.tpl.php", array('payment_id' => $payment_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

}