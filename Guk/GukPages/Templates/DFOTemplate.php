<?php

namespace Guk\GukPages\Templates;

class DFOTemplate
{
    static public function render(){
        ?>
        <h1>Создание заявки в ДФО</h1>

        <div>Выберите заявки ВУЗов, которые должны быть включены на заявку на перечисление средств:</div>

    <form action="<?= \Guk\GukPages\ControllerDFO::dfoGenerateUrl(); ?>" method="POST">
        <input type="hidden" name="a" value="generate_dfo_request">

        <table class="table">

            <thead>
            <tr>
                <th>-</th>
                <th>Заявка</th>
                <th>ВУЗ</th>
                <th><span class="glyphicon glyphicon-arrow-down"></span> Дата создания</th>
            </tr>
            </thead>

            <?php

            $request_ids_arr = \OLOG\DB\DBWrapper::readColumn(
                \AppConfig\Config::DB_NAME_GUK_FINANCE,
                'select id from ' . \Guk\FinRequest::DB_TABLE_NAME . ' where status_code in (?) order by created_at_ts desc',
                array(\Guk\FinRequest::STATUS_APPROVED_BY_GUK)
            );

            foreach ($request_ids_arr as $request_id){
                $request_obj = \Guk\FinRequest::factory($request_id);
                $vuz_obj = \Guk\Vuz::factory($request_obj->getVuzId());

                echo '<tr>';
                echo '<td><input type="checkbox" name="request_' . $request_id . '"></td>';
                echo '<td>' . \Guk\Helpers::replaceEmptyString($request_obj->getTitle()) . '</td>';
                echo '<td>' . $vuz_obj->getTitle() . '</td>';
                echo '<td>' . date('d.m.Y', $request_obj->getCreatedAtTs()) . '</td>';
                echo '</tr>';
            }

            ?>

        </table>

        <div><input type="submit" class="btn btn-primary" value="Создать заявку в ДФО"></div>

        </form><?php
    }
}