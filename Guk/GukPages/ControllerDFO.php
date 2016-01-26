<?php

namespace Guk\GukPages;

class ControllerDFO
{
    const OPERATION_CODE_ADD_PAYMENTS_GROUP = 'OPERATION_CODE_ADD_PAYMENTS_GROUP';

    static public function dfoUrl(){
        return '/guk/dfo';
    }

    public function dfoAction(){
        ob_start();
        \Guk\GukPages\Templates\DFOTemplate::render();
        $content = ob_get_clean();

        \Guk\GukPages\GukLayoutTemplate::render($content);
    }

    static public function dfoGenerateUrl(){
        return '/guk/dfo/generate';
    }

    public function dfoGenerateAction(){
        \Cebera\BT::matchOperation(self::OPERATION_CODE_ADD_PAYMENTS_GROUP, function(){\Guk\GukPages\ControllerDFO::dfoAddPaymentsGroupOperation();});

        ob_start();
        \Guk\GukPages\DFOGenerateTemplate::render();
        $content = ob_get_clean();

        \Guk\GukPages\GukLayoutTemplate::render($content);
    }

    public function dfoAddPaymentsGroupOperation()
    {
        $vuz_request_ids_arr = array();

        foreach ($_POST as $post_key => $post_value){
            $matches_arr = array();
            if (preg_match('@^request_(\d+)$@', $post_key, $matches_arr)){
                array_push($vuz_request_ids_arr, $matches_arr[1]);
            }
        }

        $payments_group_obj = new \Guk\PaymentsGroup();
        $payments_group_obj->save();

        foreach ($vuz_request_ids_arr as $vuz_request_id){
            $vuz_request_obj = \Guk\FinRequest::factory($vuz_request_id);

            $form_id = $vuz_request_obj->getFinFormId();
            $form_obj = \Guk\FinForm::factory($form_id);

            $form_row_ids_arr = $form_obj->getRowIdsArrByWeight();
            $requested_sum_col_id = $form_obj->getRequestedSumColId();
            \OLOG\Helpers::assert($requested_sum_col_id);

            $vuz_id = $vuz_request_obj->getVuzId();
            $vuz_obj = \Guk\Vuz::factory($vuz_id);

            foreach ($form_row_ids_arr as $form_row_id){
                $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($vuz_request_id, $form_row_id, $requested_sum_col_id);

                if ($request_cell_obj) {
                    $form_row_obj = \Guk\FinFormRow::factory($form_row_id);

                    $value = $request_cell_obj->getCorrectedValue();
                    if (!$value) {
                        $value = $request_cell_obj->getValue();
                    }

                    if ($value) {
                        $payment_obj = new \Guk\VuzPayment();

                        $payment_obj->setPaymentsGroupId($payments_group_obj->getId());
                        $payment_obj->setAmountRub($value);
                        $payment_obj->setVuzId($vuz_id);
                        $payment_obj->setRequestId($vuz_request_id);
                        $payment_obj->setFormRowId($form_row_id);

                        $payment_obj->save();
                    }
                }
            }
        }
    }
}