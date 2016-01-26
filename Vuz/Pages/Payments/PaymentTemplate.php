<?php

namespace Vuz\Pages\Payments;

class PaymentTemplate
{
    const MODAL_ID_PARTIAL_PAYMENT = 'MODAL_ID_PARTIAL_PAYMENT';
    const MODAL_ID_COMPLETE_PAYMENT = 'MODAL_ID_COMPLETE_PAYMENT';

    const FIELD_NAME_RECEIVED_SUM = 'FIELD_NAME_RECEIVED_SUM';

    static public function render($payment_id){
        $payment_obj = \Guk\VuzPayment::factory($payment_id);

        ?>

        <h1><a href="<?php echo \Vuz\Pages\Payments\Controller::paymentsPageUrl(); ?>">Платежи</a> / <?php echo \Guk\Helpers::replaceEmptyString($payment_obj->getTitle()); ?></h1>

        <div>&nbsp;</div>

        <form class="form-horizontal" method="post" action="<?php echo \Vuz\Pages\Payments\Controller::paymentUrl($payment_obj->getId()); ?>">

        <?php

        echo \Cebera\BT::formGroup(
            'Название',
            \Cebera\BT::formInput('', $payment_obj->getTitle(), true)
        );

        echo \Cebera\BT::formGroup(
            'Сумма платежа, руб.',
            \Cebera\BT::formInput('', $payment_obj->getAmountRub(), true)
        );

        echo \Cebera\BT::formGroup(
            'Статус заявки',
            \Cebera\BT::formInput('', \Guk\VuzPayment::getStatusStrForCode($payment_obj->getStatusCode()), true)
        );

        echo \Cebera\BT::formGroup(
            'Полученная сумма, руб.',
            \Cebera\BT::formInput('', $payment_obj->getReceivedAmountRub(), true)
        );

        echo \Cebera\BT::endForm();

        if ($payment_obj->getStatusCode() == \Guk\VuzPayment::STATUS_SENT_TO_VUZ) {
            echo \Cebera\BT::div_plain(
                \Cebera\BT::modalToggleButton(self::MODAL_ID_COMPLETE_PAYMENT, 'Платеж получен полностью') .
                \Cebera\BT::modalToggleButton(self::MODAL_ID_PARTIAL_PAYMENT, 'Платеж получен не полностью')
            );
        }

        echo \Cebera\BT::beginModal(self::MODAL_ID_COMPLETE_PAYMENT, 'Платеж получен полностью');
        echo \Cebera\BT::beginForm(\Vuz\Pages\Payments\Controller::paymentUrl($payment_id), \Vuz\Pages\Payments\Controller::OPERATION_CODE_COMPLETE_PAYMENT);
        echo \Cebera\BT::beginModalBody();
        echo \Cebera\BT::formGroup('Сумма платежа, руб.', '<input class="form-control" disabled value="' . $payment_obj->getAmountRub() . '">');
        echo \Cebera\BT::endModalBody();
        echo \Cebera\BT::modalFooterCloseAndSubmit();
        echo \Cebera\BT::endForm();
        echo \Cebera\BT::endModal();

        echo \Cebera\BT::beginModal(self::MODAL_ID_PARTIAL_PAYMENT, 'Платеж получен не полностью');
        echo \Cebera\BT::beginForm(\Vuz\Pages\Payments\Controller::paymentUrl($payment_id), \Vuz\Pages\Payments\Controller::OPERATION_CODE_PARTIAL_PAYMENT);
        echo \Cebera\BT::beginModalBody();
        echo \Cebera\BT::formGroup('Сумма платежа, руб.', '<input class="form-control" disabled value="' . $payment_obj->getAmountRub() . '">');
        echo \Cebera\BT::formGroup('Полученная сумма, руб.', '<input class="form-control" name="' . self::FIELD_NAME_RECEIVED_SUM . '" value="">');
        echo \Cebera\BT::endModalBody();
        echo \Cebera\BT::modalFooterCloseAndSubmit();
        echo \Cebera\BT::endForm();
        echo \Cebera\BT::endModal();
    }
}