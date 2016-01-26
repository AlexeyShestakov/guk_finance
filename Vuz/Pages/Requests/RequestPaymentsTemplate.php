<?php

namespace Vuz\Pages\Requests;

class RequestPaymentsTemplate
{
    static public function render($vuz_id, $request_id){
        $request_obj = \Guk\FinRequest::factory($request_id);

        //$vuz_obj = \Guk\Vuz::factory($vuz_id);

        ?>

        <h1><a href="/vuz">Заявки</a> / <?php echo \Guk\Helpers::replaceEmptyString($request_obj->getTitle()); ?></h1>

        <?php \Vuz\Pages\Requests\RequestTabs::render($request_id); ?>

        <div>&nbsp;</div>

        <?php
//echo '<div><a class="btn btn-default" href="' . \Guk\VuzPage\ControllerVuz::addPaymentToRequestUrl($request_id) . '">Добавить платеж</a></div>';
        ?>

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

                $form_row_id = $payment_obj->getFormRowId();
                $form_row_obj = \Guk\FinFormRow::factory($form_row_id);

                $row_terms_str_arr = $form_row_obj->getTermsStrArr();
                $row_terms_str = implode('<br>', $row_terms_str_arr);

                echo '<tr>';
                echo '<td>' . $row_terms_str . '</td>';
                echo '<td><a href="' . \Vuz\Pages\Payments\Controller::paymentUrl($payment_obj->getId()) . '">' . \Guk\Helpers::replaceEmptyString($payment_obj->getTitle()) . '</a></td>';
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