<?php

namespace Vuz\Pages\Requests;

use Cebera\BT;

class RequestsController
{
    const OPERATION_SET_DETAIL_TERM_ID = 'OPERATION_SET_DETAIL_TERM_ID';

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

    public static function finRequestFillPageAction($mode, $request_id)
    {
        $self_url = '/vuz/finrequest/' . $request_id . '/fill';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        $vuz_id = \Vuz\Auth::getCurrentOperatorVuzId();

        BT::matchOperation(self::OPERATION_SET_DETAIL_TERM_ID, function() use($vuz_id, $request_id) {
            $term_id = BT::getPostValue('term_id');
            $context_str = BT::getPostValue('context');
            list($detail_row_id, $detail_col_id) = explode(',', $context_str);

            $detail_cell_obj = \Guk\DetailCell::getObjForRowAndCol($detail_row_id, $detail_col_id);
            if (!$detail_cell_obj){
                $detail_cell_obj = new \Guk\DetailCell();
                $detail_cell_obj->setDetailColumnId($detail_col_id);
                $detail_cell_obj->setDetailRowId($detail_row_id);
            }

            $detail_cell_obj->setTermId($term_id);
            $detail_cell_obj->save();

        });

        if (array_key_exists('a', $_POST)) {
            if ($_POST['a'] == 'set_value') {
                $row_id = $_POST['row_id'];
                $col_id = $_POST['col_id'];
                $value = $_POST['value'];

                $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($request_id, $row_id, $col_id);
                if ($request_cell_obj) {
                    $request_cell_obj->setValue($value);
                    $request_cell_obj->save();
                } else {
                    $request_cell_obj = new \Guk\FinRequestCell();
                    $request_cell_obj->setFinRequestId($request_id);
                    $request_cell_obj->setRowId($row_id);
                    $request_cell_obj->setColId($col_id);
                    $request_cell_obj->setValue($value);
                    $request_cell_obj->save();
                }
            }

            if ($_POST['a'] == 'set_request_status_code') {

                $status_code = $_POST['status_code'];
                $request_obj = \Guk\FinRequest::factory($request_id);

                $old_status_code = $request_obj->getStatusCode();

                $request_obj->setStatusCode($status_code);
                $request_obj->save();

                $request_obj->logChange('ВУЗ изменил статус заявки с "' . \Guk\FinRequest::getStatusStrForCode($old_status_code) . '" на "' . \Guk\FinRequest::getStatusStrForCode($status_code) . '"".');
            }
        }

        //$content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_fill_page.tpl.php", array('request_id' => $request_id));
        ob_start();
        RequestFillTemplate::render($request_id);
        $content = ob_get_clean();

        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }
}