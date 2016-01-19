<?php

?>

<h1>Платежи</h1>

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

    $payment_ids_arr = \Guk\VuzPayment::getAllPaymentsIdsArrByCreatedAtDesc();

    foreach ($payment_ids_arr as $payment_id){
        $payment_obj = \Guk\VuzPayment::factory($payment_id);

        echo '<tr>';
        echo '<td><a href="' . \Guk\FinFormsPage\ControllerFinFormsPage::paymentUrl($payment_obj->getId()) . '">' . \Cebera\Helpers::replaceEmptyValue($payment_obj->getTitle()) . '</a></td>';
        echo '<td>' . $payment_obj->getAmountRub() . '</td>';
        echo '<td>' . date('d.m.Y', $payment_obj->getCreatedAtTs()) . '</td>';
        echo '<td>' . \Guk\VuzPayment::getStatusStrForCode($payment_obj->getStatusCode()) . '</td>';
        echo '</tr>';
    }

    ?>

</table>
