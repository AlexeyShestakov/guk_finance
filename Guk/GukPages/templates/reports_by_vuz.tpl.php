<h1>Заявки по ВУЗам</h1>

<?php

$form_id = \Guk\FinFormHelper::getCurrentFormId();

if (!$form_id){
    echo '<div class="alert alert-warning" role="alert">Не назначена текущая форма.</div>';
    return;
}

$form_obj = \Guk\FinForm::factory($form_id);

$row_ids_arr = $form_obj->getRowIdsArrByWeight();
$col_ids_arr = $form_obj->getColIdsArrByWeight();

$requested_sum_col_id = 0;

foreach ($col_ids_arr as $col_id) {
    $col_obj = \Guk\FinFormCol::factory($col_id);
    if ($col_obj->getIsRequestedSum()){
        $requested_sum_col_id = $col_id;
    }
}

if (!$requested_sum_col_id){
    echo '<div class="alert alert-warning" role="alert">В выбранной форме нет колонки с запрошенной суммой.</div>';
    return;
}

$request_ids_arr = \Guk\FinRequest::getRequestIdsArrForFormByCreatedAtDesc($form_id);

$vuz_ids_arr = array();

foreach ($request_ids_arr as $request_id){
    $request_obj = \Guk\FinRequest::factory($request_id);
    $request_vuz_id = $request_obj->getVuzId();
    if (!in_array($request_vuz_id, $vuz_ids_arr)){
        array_push($vuz_ids_arr, $request_vuz_id);
    }
}

echo '<table class="table table-condensed table-bordered table-striped"><thead>';
echo '<thead><tr>';
echo '<th>ВУЗ</th>';
echo '<th>Запрошено</th>';
echo '<th>Выделено</th>';
echo '</tr></thead>';

foreach ($vuz_ids_arr as $vuz_id){
    $vuz_obj = \Guk\Vuz::factory($vuz_id);

    echo '<tr>';
    echo '<td>' . $vuz_obj->getTitle() . '</td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '</tr>';
}

echo '</table>';