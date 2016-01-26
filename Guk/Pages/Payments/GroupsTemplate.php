<?php

namespace Guk\Pages\Payments;

class GroupsTemplate
{
    static public function render(){
        ?>

        <h1>Группы платежей (заявки ДФО)</h1>

        <table class="table">

            <thead>
            <tr>
                <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
            </tr>
            </thead>

            <?php

            $groups_ids_arr = \Guk\PaymentsGroup::getIdsArrByCreatedAt();

            foreach ($groups_ids_arr as $group_id){
                $group_obj = \Guk\PaymentsGroup::factory($group_id);

                echo '<tr>';
                echo '<td><a href="' . \Guk\Pages\Payments\Controller::groupUrl($group_id) . '">edit</a></td>';
                echo '<td>' . date('d.m.Y', $group_obj->getCreatedAtTs()) . '</td>';
                echo '</tr>';
            }

            ?>

        </table>

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