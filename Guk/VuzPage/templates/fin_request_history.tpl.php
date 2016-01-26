<?php
/**
 * @var $request_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);

?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Guk\Helpers::replaceEmptyString($request_obj->getTitle()); ?></h1>

<?php \Vuz\Pages\Requests\RequestTabs::render($request_id); ?>

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

$log_ids_arr = \OLOG\DB\DBWrapper::readColumn(
    \AppConfig\Config::DB_NAME_GUK_FINANCE,
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

