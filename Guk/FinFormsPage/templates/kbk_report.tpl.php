<h1>Отчет по КБК</h1>

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

//echo '<p>requested_sum_col_id: ' . $requested_sum_col_id . '</p>';

echo '<table class="table table-condensed table-bordered table-striped"><thead>';
echo '<tr>';
echo '<th>№</th>';
echo '<th>КБК</th>';
echo '<th>Лимит</th>';
echo '<th>Запрошено всего</th>';
echo '<th>Подтверждено</th>';
echo '</tr></thead>';

foreach ($row_ids_arr as $row_id){
    $row_obj = \Guk\FinFormRow::factory($row_id);

    $requested_sum = 0;
    $approved_sum = 0;

    $request_cell_ids_arr = \Cebera\DB\DBWrapper::readColumn(
        \Cebera\Conf::DB_NAME_GUK_FINANCE,
        'select id from ' . \Guk\FinRequestCell::DB_TABLE_NAME . ' where row_id = ? and col_id = ?',
        array($row_id, $requested_sum_col_id)
    );

    foreach ($request_cell_ids_arr as $request_cell_id){
        $request_cell_obj = \Guk\FinRequestCell::factory($request_cell_id);

        $requested_sum += intval($request_cell_obj->getValue());

        $request_id = $request_cell_obj->getFinRequestId();
        $request_obj = \Guk\FinRequest::factory($request_id);

        $request_status_code = $request_obj->getStatusCode();

        if ($request_status_code == \Guk\FinRequest::STATUS_APPROVED_BY_GUK){
            $approved_sum += intval($request_cell_obj->getValue());
        }
    }

    echo '<tr>';
    echo '<td>' . $row_obj->getWeight() . '</td>';
    echo '<td>' . $row_obj->getKbk() . '</td>';
    echo '<td>' . $row_obj->getLimit() . '</td>';
    echo '<td>' . $requested_sum . '</td>';
    echo '<td>' . $approved_sum . '</td>';

    echo '</tr>';
}

echo '</table>';
