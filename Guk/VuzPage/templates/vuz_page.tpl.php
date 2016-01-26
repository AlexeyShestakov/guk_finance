<?php
/*

$vuz_id

*/

$vuz_obj = \Guk\Vuz::factory($vuz_id);

?>

<h1>Заявки <a href="/vuz/finrequest">+</a></h1>

<table class="table">

    <thead>
    <tr>
        <th>Заявка</th>
        <th><span class="glyphicon glyphicon-sort-by-attributes-alt"></span> Дата создания</th>
        <th>Статус</th>
    </tr>
    </thead>

<?php

$request_ids_arr = $vuz_obj->getFinRequestIdsArrByCreatedAtDesc();

foreach ($request_ids_arr as $request_id){
    $request_obj = \Guk\FinRequest::factory($request_id);

    $row_class = '';

    if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_IN_GUK_REWIEW){
        $row_class = ' info ';
    }

    if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_REJECTED_BY_GUK){
        $row_class = ' danger ';
    }

    if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_APPROVED_BY_GUK){
        $row_class = ' success ';
    }

    echo '<tr class="' . $row_class . '">';
    echo '<td><a href="/vuz/finrequest/' . $request_obj->getId() . '/fill">' . \Guk\Helpers::replaceEmptyString($request_obj->getTitle()) . '</a></td>';
    echo '<td>' . date('d.m.Y', $request_obj->getCreatedAtTs()) . '</td>';
    echo '<td>' . $request_obj::getStatusStrForCode($request_obj->getStatusCode()) . '</td>';
    echo '</tr>';
}

?>

</table>
