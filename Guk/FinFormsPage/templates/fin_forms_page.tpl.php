<h1>Формы</h1>

<table class="table">

<?php

$form_ids_arr = \Cebera\DB\DBWrapper::readColumn(
    \Cebera\Conf::DB_NAME_GUK_FINANCE,
    'select id from ' . \Guk\FinForm::DB_TABLE_NAME . ' order by id desc'
);

foreach ($form_ids_arr as $form_id){
    $form_obj = \Guk\FinForm::factory($form_id);

    echo '<tr><td><a href="/finform/' . $form_obj->getId() . '">' . \Cebera\Helpers::replaceEmptyValue($form_obj->getComment()) . '</a></td></tr>';
}

?>

</table>

