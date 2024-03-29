<?php

namespace Guk\Pages\Requests;

class RequestPaymentsTemplate
{
    static public function render($request_id){
        $request_obj = \Guk\FinRequest::factory($request_id);

        ?>

        <h1><a href="<?= \Guk\Pages\Requests\ControllerRequests::getFinRequestsUrl() ?>">Заявки</a> / <?= $request_obj->getTitle() ?></h1>

        <ul class="nav nav-tabs">
            <li role="presentation"><a href="<?php echo \Guk\Pages\Requests\ControllerRequests::getFinRequestUrl($request_obj->getId()); ?>">Данные</a></li>
            <li role="presentation"><a href="">История</a></li>
            <li role="presentation" class="active"><a href="<?= \Guk\Pages\Requests\ControllerRequests::requestPaymentsUrl($request_id); ?>">Платежи</a></li>
        </ul>

        <div>&nbsp;</div>

        <div><a class="btn btn-primary" href="<?= \Guk\Pages\Requests\ControllerRequests::addPaymentToRequestUrl($request_id) ?>">Добавить платеж</a></div>

        <table class="table">

            <thead>
            <tr>
                <th>Заявка</th>
                <th>Сумма</th>
                <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
                <th>Статус</th>
            </tr>
            </thead>

            <?php

            $payment_ids_arr = $request_obj->getPaymentIdsArrByCreatedAtDesc();

            foreach ($payment_ids_arr as $payment_id){
                $payment_obj = \Guk\VuzPayment::factory($payment_id);

                echo '<tr>';
                echo '<td><a href="' . \Guk\Pages\Payments\Controller::paymentUrl($payment_obj->getId()) . '">' . \Guk\Helpers::replaceEmptyString($payment_obj->getTitle()) . '</a></td>';
                echo '<td>' . $payment_obj->getAmountRub() . '</td>';
                echo '<td>' . date('d.m.Y', $payment_obj->getCreatedAtTs()) . '</td>';
                echo '<td>' . \Guk\VuzPayment::getStatusStrForCode($payment_obj->getStatusCode()) . '</td>';
                echo '</tr>';
            }

            ?>

        </table>

        <?php
    }
}