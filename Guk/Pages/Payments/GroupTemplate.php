<?php

namespace Guk\Pages\Payments;

class GroupTemplate
{
    const FIELD_NAME_NEW_STATUS_CODE = 'FIELD_NAME_NEW_STATUS_CODE';

    static public function render($group_id)
    {
        echo \Cebera\BT::h1_plain(\Cebera\BT::a(\Guk\Pages\Payments\Controller::paymentsUrl(), 'Платежи') . ' / Группа');

        echo '<div>';

        echo \Cebera\BT::operationButton(
            \Guk\Pages\Payments\Controller::groupUrl($group_id),
            \Guk\Pages\Payments\Controller::OPERATION_UPDATE_PAYMENT_STATUS,
            'Черновик',
            array(self::FIELD_NAME_NEW_STATUS_CODE => \Guk\VuzPayment::STATUS_DRAFT)
        );

        echo \Cebera\BT::operationButton(
            \Guk\Pages\Payments\Controller::groupUrl($group_id),
            \Guk\Pages\Payments\Controller::OPERATION_UPDATE_PAYMENT_STATUS,
            'Отправить в ДФО',
            array(self::FIELD_NAME_NEW_STATUS_CODE => \Guk\VuzPayment::STATUS_IN_DFO)
        );

        echo \Cebera\BT::operationButton(
            \Guk\Pages\Payments\Controller::groupUrl($group_id),
            \Guk\Pages\Payments\Controller::OPERATION_UPDATE_PAYMENT_STATUS,
            'Отправить в ВУЗ',
            array(self::FIELD_NAME_NEW_STATUS_CODE => \Guk\VuzPayment::STATUS_SENT_TO_VUZ)
        );

        echo '</div>';

        ?>

        <table class="table">

            <thead>
            <tr>
                <th>ВУЗ</th>
                <th>Заявка</th>
                <th>Сумма</th>
                <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
                <th>Статус</th>
            </tr>
            </thead>

        <?php

        $payment_ids_arr = \Guk\VuzPayment::getIdsArrForGroupIdByCreatedAtDesc($group_id);

        foreach ($payment_ids_arr as $payment_id) {
            $payment_obj = \Guk\VuzPayment::factory($payment_id);
            $vuz_obj = \Guk\Vuz::factory($payment_obj->getVuzId());

            echo '<tr>';
            echo '<td>' . $vuz_obj->getTitle() . '</td>';
            echo '<td><a href="' . \Guk\Pages\Payments\Controller::paymentUrl($payment_obj->getId()) . '">' . \Guk\Helpers::replaceEmptyString($payment_obj->getTitle()) . '</a></td>';
            echo '<td>' . $payment_obj->getAmountRub() . '</td>';
            echo '<td>' . date('d.m.Y', $payment_obj->getCreatedAtTs()) . '</td>';
            echo '<td>' . \Guk\VuzPayment::getStatusStrForCode($payment_obj->getStatusCode()) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
   }
}