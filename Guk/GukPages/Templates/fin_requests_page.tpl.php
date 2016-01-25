<h1>Заявки</h1>

<table class="table">

    <thead>
    <tr>
        <th>Заявка</th>
        <th>ВУЗ</th>
        <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
        <th>Статус</th>
    </tr>
    </thead>

    <?php

    $request_ids_arr = \OLOG\DB\DBWrapper::readColumn(
        \AppConfig\Config::DB_NAME_GUK_FINANCE,
        'select id from ' . \Guk\FinRequest::DB_TABLE_NAME . ' where status_code in (?, ?, ?) order by created_at_ts desc',
        array(\Guk\FinRequest::STATUS_IN_GUK_REWIEW, \Guk\FinRequest::STATUS_APPROVED_BY_GUK, \Guk\FinRequest::STATUS_REJECTED_BY_GUK)
    );

    foreach ($request_ids_arr as $request_id){
        $request_obj = \Guk\FinRequest::factory($request_id);
        $vuz_obj = \Guk\Vuz::factory($request_obj->getVuzId());

        echo '<tr>';
        echo '<td><a href="/guk/finrequest/' . $request_obj->getId() . '">' . $request_obj->getTitle() . '</a></td>';
        echo '<td>' . $vuz_obj->getTitle() . '</td>';
        echo '<td>' . date('d.m.Y', $request_obj->getCreatedAtTs()) . '</td>';
        echo '<td>' . $request_obj::getStatusStrForCode($request_obj->getStatusCode()) . '</td>';
        echo '</tr>';
    }

    ?>

</table>

