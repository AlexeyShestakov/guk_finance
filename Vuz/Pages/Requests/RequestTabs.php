<?php

namespace Vuz\Pages\Requests;

class RequestTabs
{
    static public function render($request_id){

        $camn = \OLOG\Router::getCurrentActionMethodName();

        ?>

        <ul class="nav nav-tabs">
            <li role="presentation" <?php if ($camn == 'finRequestFillPageAction'){ echo ' class="active" '; } ?> ><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_id); ?>">Заполнение</a></li>
            <li role="presentation" <?php if ($camn == 'finRequestEditAction'){ echo ' class="active" '; } ?> ><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestEditUrl($request_id); ?>">Параметры</a></li>
            <li role="presentation" <?php if ($camn == 'finRequestUploadAction'){ echo ' class="active" '; } ?> ><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestUploadUrl($request_id) ?>">Обоснование</a></li>
            <li role="presentation" <?php if ($camn == 'finRequestHistoryAction'){ echo ' class="active" '; } ?> ><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestHistoryUrl($request_id) ?>">История</a></li>
            <li role="presentation" <?php if ($camn == 'finRequestPrintAction'){ echo ' class="active" '; } ?> ><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestPrintUrl($request_id) ?>">Печать</a></li>
            <li role="presentation" <?php if ($camn == 'requestPaymentsPageAction'){ echo ' class="active" '; } ?> ><a href="<?= \Guk\VuzPage\ControllerVuz::requestPaymentsPageUrl($request_id) ?>">Платежи</a></li>
        </ul>

        <?php
    }

}