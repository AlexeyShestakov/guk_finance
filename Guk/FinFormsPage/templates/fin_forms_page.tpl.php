<h1>Формы</h1>

<table class="table">
    <thead>
    <tr>
        <th>Форма</th>
        <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
    </tr>
    </thead>

<?php

$form_ids_arr = \Cebera\DB\DBWrapper::readColumn(
    \Cebera\Conf::DB_NAME_GUK_FINANCE,
    'select id from ' . \Guk\FinForm::DB_TABLE_NAME . ' order by id desc'
);

foreach ($form_ids_arr as $form_id){
    $form_obj = \Guk\FinForm::factory($form_id);

    $row_classes = '';
    if ($form_obj->isCurrent()){
        $row_classes .= ' success ';
    }

    echo '<tr class="' . $row_classes . '">';
    echo '<td><a href="/finform/' . $form_obj->getId() . '">' . \Cebera\Helpers::replaceEmptyValue($form_obj->getComment()) . '</a></td>';
    echo '<td>' . date('d.m.Y', $form_obj->getCreatedAtTs()) . '</td>';
    echo '</tr>';
}

?>

</table>

