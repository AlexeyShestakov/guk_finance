<?php

namespace Guk\Pages\Payments;

class Controller
{
    const OPERATION_UPDATE_PAYMENT_STATUS = 'OPERATION_UPDATE_PAYMENT_STATUS';

    static public function paymentsUrl(){
        return '/guk/payments';
    }

    public function paymentsAction(){
        ob_start();
        \Guk\Pages\Payments\GroupsTemplate::render();
        $content = ob_get_clean();
        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function groupUrl($group_id){
        return '/guk/payments_group/' . $group_id;
    }

    public function groupAction($group_id){
        \Cebera\BT::matchOperation(self::OPERATION_UPDATE_PAYMENT_STATUS, function() use($group_id){self::sendGroupToDFOOperation($group_id);});

        ob_start();
        \Guk\Pages\Payments\GroupTemplate::render($group_id);
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function sendGroupToDFOOperation($group_id){
        $new_status_code = \Cebera\BT::getPostValue(\Guk\Pages\Payments\GroupTemplate::FIELD_NAME_NEW_STATUS_CODE);

        $payment_ids_arr = \Guk\VuzPayment::getIdsArrForGroupIdByCreatedAtDesc($group_id);
        foreach ($payment_ids_arr as $payment_id){
            $payment_obj = \Guk\VuzPayment::factory($payment_id);
            $payment_obj->setStatusCode($new_status_code);
            $payment_obj->save();
        }
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

        //$content = \Cebera\Render\Render::callLocaltemplate("Templates/payment.tpl.php", array('payment_id' => $payment_id));
        ob_start();
        \Guk\Pages\Payments\PaymentTemplate::render($payment_id);
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

}