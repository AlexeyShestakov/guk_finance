<?php
/**
 * @var $request_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);

?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($request_obj->getTitle()); ?></h1>

<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()); ?>">Заполнение</a></li>
    <li role="presentation"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestEditUrl($request_obj->getId()); ?>">Параметры</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestUploadUrl($request_obj->getId()) ?>">Обоснование</a></li>
    <li role="presentation" class="active"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestHistoryUrl($request_obj->getId()) ?>">История</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestPrintUrl($request_obj->getId()) ?>">Печать</a></li>
</ul>

<div>&nbsp;</div>

<table class="table">

    <thead>
    <tr>
        <th>Дата</th>
        <th>Изменение</th>
        <th>Комментарий</th>
    </tr>
    </thead>

<?php

$log_ids_arr = \Cebera\DB\DBWrapper::readColumn(
    \Cebera\Conf::DB_NAME_GUK_FINANCE,
    'select id from fin_request_log where request_id = ? order by created_at_ts desc',
    array($request_id)
);

foreach ($log_ids_arr as $log_id){
    $log_obj = \Guk\FinRequestLog::factory($log_id);

    echo '<tr>';
    echo '<td>' . date('d.m.Y', $log_obj->getCreatedAtTs()) . '</td>';
    echo '<td>' . $log_obj->getChangeInfo() . '</td>';
    echo '<td>' . $log_obj->getComment() . '</td>';
    echo '</tr>';

}

?>

    <table>

