<?php

namespace Vuz\Pages\Payments;

class Controller
{
    const OPERATION_CODE_PARTIAL_PAYMENT = 'OPERATION_CODE_PARTIAL_PAYMENT';
    const OPERATION_CODE_COMPLETE_PAYMENT = 'OPERATION_CODE_COMPLETE_PAYMENT';

    static public function paymentsPageUrl(){
        return '/vuz/payments';
    }

    public function paymentsPageAction(){
        $vuz_id = \Vuz\Auth::getCurrentOperatorVuzId();

        ob_start();
        \Vuz\Pages\Payments\PaymentsTemplate::render($vuz_id);
        $content = ob_get_clean();

        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }

    static public function paymentUrl($payment_id){
        return '/vuz/payment/' . $payment_id;
    }

    public function paymentPageAction($payment_id){
        $vuz_id = \Vuz\Auth::getCurrentOperatorVuzId();

        \Cebera\BT::matchOperation(self::OPERATION_CODE_PARTIAL_PAYMENT, function() use($payment_id){self::partialPaymentOperation($payment_id);});
        \Cebera\BT::matchOperation(self::OPERATION_CODE_COMPLETE_PAYMENT, function() use($payment_id){self::completePaymentOperation($payment_id);});

        ob_start();
        \Vuz\Pages\Payments\PaymentTemplate::render($payment_id);
        $content = ob_get_clean();

        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }

    static public function partialPaymentOperation($payment_id){
        $payment_obj = \Guk\VuzPayment::factory($payment_id);

        $payment_obj->setStatusCode(\Guk\VuzPayment::STATUS_RECEIVED_BY_VUZ_PARTIAL);
        $payment_obj->setReceivedAmountRub(\Cebera\BT::getPostValue(\Vuz\Pages\Payments\PaymentTemplate::FIELD_NAME_RECEIVED_SUM));
        $payment_obj->save();
    }

    static public function completePaymentOperation($payment_id){
        $payment_obj = \Guk\VuzPayment::factory($payment_id);

        $payment_obj->setStatusCode(\Guk\VuzPayment::STATUS_RECEIVED_BY_VUZ_COMPLETE);
        $payment_obj->save();
    }
}