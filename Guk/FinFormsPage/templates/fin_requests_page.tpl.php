<h1>Заявки</h1>

<table class="table">

    <tr>
        <th>ВУЗ</th>
        <th>заявка</th>
        <th></th>
    </tr>

    <?php

    $request_ids_arr = \Cebera\DB\DBWrapper::readColumn(
        \Cebera\Conf::DB_NAME_GUK_FINANCE,
        'select id from ' . \Guk\FinRequest::DB_TABLE_NAME . ' order by id desc'
    );

    foreach ($request_ids_arr as $request_id){
        $request_obj = \Guk\FinRequest::factory($request_id);
        $vuz_obj = \Guk\Vuz::factory($request_obj->getVuzId());

        echo '<tr><td>' . $vuz_obj->getTitle() . '</td><td>' . $request_obj->getTitle() . '</td><td><a href="/guk/finrequest/' . $request_obj->getId() . '">изменить</a></td></tr>';
    }

    ?>

</table>

