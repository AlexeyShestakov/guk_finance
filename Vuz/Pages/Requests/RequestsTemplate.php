<?php

namespace Vuz\Pages\Requests;

use Cebera\BT;
use \Vuz\Pages\Requests\RequestsController;

class RequestsTemplate
{
    const MODAL_ADD_REQUEST = 'MODAL_ADD_REQUEST';
    const OPERATION_ADD_REQUEST = 'OPERATION_ADD_REQUEST';
    const FIELD_REQUEST_TITLE = 'FIELD_REQUEST_TITLE';

    static public function render($vuz_id){


$vuz_obj = \Guk\Vuz::factory($vuz_id);

echo BT::pageHeader_plain('Заявки');

echo BT::toolbar_plain(BT::modalToggleButton(self::MODAL_ADD_REQUEST, 'Создать'));

?>
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

    echo '</table>';

        echo BT::beginModalForm(self::MODAL_ADD_REQUEST, 'Создание заявки', RequestsController::requestsAction(1), self::OPERATION_ADD_REQUEST);
        echo BT::formGroup(
            'Название',
            BT::formInput(self::FIELD_REQUEST_TITLE, '')
        );
        echo BT::endModalForm();

    }
}