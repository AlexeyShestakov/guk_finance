<?php

namespace Guk\Pages\Forms;

class FormsTemplate
{
    const MODAL_ID_ADD_FORM = 'MODAL_ID_ADD_FORM';
    const FIELD_NAME_FORM_TITLE = 'FIELD_NAME_FORM_TITLE';

    static public function render()
    {
        echo \Cebera\BT::pageHeader_plain('Формы');
        echo \Cebera\BT::div_plain(\Cebera\BT::modalToggleButton(self::MODAL_ID_ADD_FORM, 'Создать'));

        echo \Cebera\BT::beginTable();

        ?>
        <thead>
        <tr>
            <th>Форма</th>
            <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
        </tr>
        </thead>

        <?php

        $form_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\FinForm::DB_TABLE_NAME . ' where is_hidden = 0 order by created_at_ts desc'
        );

        foreach ($form_ids_arr as $form_id) {
            $form_obj = \Guk\FinForm::factory($form_id);

            $row_classes = '';
            if ($form_obj->isCurrent()) {
                $row_classes .= ' success ';
            }

            echo \Cebera\BT::beginTr($row_classes);
            echo '<td>' . \Cebera\BT::a(FormsController::formAction(1, $form_obj->getId()), $form_obj->getComment()) . '</td>';
            echo \Cebera\BT::td(date('d.m.Y', $form_obj->getCreatedAtTs()));
            echo \Cebera\BT::endTr();
        }

        echo \Cebera\BT::endTable();

        echo \Cebera\BT::beginModalForm(self::MODAL_ID_ADD_FORM, 'Создание формы', \Guk\Pages\Forms\FormsController::formsAction(1), \Guk\Pages\Forms\FormsController::ADD_FORM_OPERATION_CODE);
        echo \Cebera\BT::formGroup('Название', '<input class="form-control" name="' . self::FIELD_NAME_FORM_TITLE . '" value="">');
        echo \Cebera\BT::endModalForm();
    }
}