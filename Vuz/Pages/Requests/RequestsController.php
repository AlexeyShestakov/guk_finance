<?php

namespace Vuz\Pages\Requests;

use Cebera\BT;

class RequestsController
{

    public static function requestsAction($mode)
    {
        $self_url = '/vuz';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        $vuz_id = \Vuz\Auth::getCurrentOperatorVuzId();

        //

        BT::matchOperation(RequestsTemplate::OPERATION_ADD_REQUEST, function() use($vuz_id) {
            $fin_form_id = \Guk\FinFormHelper::getCurrentFormId();
            \OLOG\Helpers::assert($fin_form_id, 'ГУК не опубликовал текущую форму заявки');

            $request_obj = new \Guk\FinRequest;
            $request_obj->setTitle(BT::getPostValue(RequestsTemplate::FIELD_REQUEST_TITLE));
            $request_obj->setVuzId($vuz_id);
            $request_obj->setCreatedAtTs(time());
            $request_obj->setFinFormId($fin_form_id);
            $request_obj->setStatusCode(\Guk\FinRequest::STATUS_DRAFT);

            $request_obj->save();

            \OLOG\Helpers::redirect(self::requestsAction(1));
        });

        //

        ob_start();
        \Vuz\Pages\Requests\RequestsTemplate::render($vuz_id);
        $content = ob_get_clean();

        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }
}