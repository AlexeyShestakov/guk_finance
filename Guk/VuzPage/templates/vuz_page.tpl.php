<?php
/*

$vuz_id

*/

$vuz_obj = \Guk\Vuz::factory($vuz_id);

?>

<h1>Заявки <a href="/vuz/finrequest">+</a></h1>

<table class="table">

<?php

$request_ids_arr = $vuz_obj->getFinRequestIdsArrByCreatedAtDesc();

foreach ($request_ids_arr as $request_id){
    $request_obj = \Guk\FinRequest::factory($request_id);

    echo '<tr><td><a href="/vuz/finrequest/' . $request_obj->getId() . '/fill">' . \Cebera\Helpers::replaceEmptyValue($request_obj->getTitle()) . '</a></td></tr>';
}

?>

</table>
