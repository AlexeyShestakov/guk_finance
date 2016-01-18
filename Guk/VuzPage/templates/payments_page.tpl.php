<?php
/*

$vuz_id

*/

$vuz_obj = \Guk\Vuz::factory($vuz_id);

?>

<h1>Платежи</h1>

<table class="table">

    <thead>
    <tr>
        <th>Заявка</th>
        <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
        <th>Статус</th>
    </tr>
    </thead>

    <?php

    $payment_ids_arr = $vuz_obj->getPaymentIdsArrByCreatedAtDesc();

    foreach ($payment_ids_arr as $payment_id){
        $payment_obj = \Guk\VuzPayment::factory($payment_id);

        echo '<tr>';
        echo '<td><a href="/vuz/finrequest/' . $payment_obj->getId() . '/fill">' . \Cebera\Helpers::replaceEmptyValue($payment_obj->getTitle()) . '</a></td>';
        echo '<td>' . date('d.m.Y', $payment_obj->getCreatedAtTs()) . '</td>';
        echo '</tr>';
    }

    ?>

</table>
