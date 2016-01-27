<?php

namespace Guk\GukPages\Templates;

class FormsTemplate
{
    static public function render()
    {
        echo '<h1>Формы ' . \Cebera\BT::a(\Guk\GukPages\ControllerForms::getFinFormAddPageUrl(), '+') . '</h1>';

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
            echo '<td>' . \Cebera\BT::a(\Guk\GukPages\ControllerForms::finFormPageAction(1, $form_obj->getId()), $form_obj->getComment()) . '</td>';
            echo \Cebera\BT::td(date('d.m.Y', $form_obj->getCreatedAtTs()));
            echo \Cebera\BT::endTr();
        }

        echo \Cebera\BT::endTable();
    }
}