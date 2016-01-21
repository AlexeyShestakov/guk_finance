<?php
/**
 * @var $request_id
 * @var $vuz_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);

$vuz_obj = \Guk\Vuz::factory($vuz_id);

?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($request_obj->getTitle()); ?></h1>

<?php echo \Cebera\Render\Render::callLocaltemplate('request_tabs.tpl.php', array("request_id" => $request_id)); ?>

<div>&nbsp;</div>

<div><a class="btn btn-primary" href="<?= \Guk\VuzPage\ControllerVuz::addPaymentToRequestUrl($request_id) ?>">Добавить платеж</a></div>

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
        echo '<td><a href="' . \Guk\VuzPage\ControllerVuz::paymentUrl($payment_obj->getId()) . '">' . \Cebera\Helpers::replaceEmptyValue($payment_obj->getTitle()) . '</a></td>';
        echo '<td>' . $payment_obj->getAmountRub() . '</td>';
        echo '<td>' . date('d.m.Y', $payment_obj->getCreatedAtTs()) . '</td>';
        echo '<td>' . \Guk\VuzPayment::getStatusStrForCode($payment_obj->getStatusCode()) . '</td>';
        echo '</tr>';
    }

    ?>

</table>
