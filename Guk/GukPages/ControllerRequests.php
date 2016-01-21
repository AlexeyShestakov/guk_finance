<?php

namespace Guk\GukPages;


class ControllerRequests
{
    static public function addPaymentToRequestUrl($request_id){
        return self::requestPaymentsUrl($request_id) . '?a=add_payment';
    }

    static public function getFinRequestUrl($request_id){
        return '/guk/finrequest/' . $request_id;
    }

    public function finRequestPageAction($request_id){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'set_request_status_code'){
                $status_code = $_POST['status_code'];
                $comment = $_POST['comment'];
                $request_obj = \Guk\FinRequest::factory($request_id);

                $old_status_code = $request_obj->getStatusCode();

                $request_obj->setStatusCode($status_code);
                $request_obj->save();

                $request_obj->logChange(
                    'ГУК изменил статус заявки с "' . \Guk\FinRequest::getStatusStrForCode($old_status_code) . '" на "' . \Guk\FinRequest::getStatusStrForCode($status_code) . '"".',
                    $comment
                );
            }

            if ($_POST['a'] == 'set_request_cell_value'){
                $request_cell_id = $_POST['request_cell_id'];
                $corrected_value = $_POST['corrected_value'];
                $comment = $_POST['comment'];
                $request_cell_obj = \Guk\FinRequestCell::factory($request_cell_id);

                $old_cell_value = $request_cell_obj->getValue();

                $request_cell_obj->setCorrectedValue($corrected_value);
                $request_cell_obj->save();

                $request_obj = \Guk\FinRequest::factory($request_id);
                $row_id = $request_cell_obj->getRowId();
                $row_obj = \Guk\FinFormRow::factory($row_id);

                $request_obj->logChange(
                    'ГУК изменил значение поля заявки с "' . $old_cell_value . '" на "' . $corrected_value . '"" в строке "' . $row_obj->getWeight() . '".',
                    $comment
                );
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_request_page.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }


    static public function requestPaymentsUrl($request_id){
        return self::getFinRequestUrl($request_id) . '/payments';
    }

    public function requestPaymentsAction($request_id){
        if (array_key_exists('a', $_GET)) {
            if ($_GET['a'] == 'add_payment') {
                $request_obj = \Guk\FinRequest::factory($request_id);

                $payment_obj = new \Guk\VuzPayment();
                $payment_obj->setTitle('Новый платеж');
                $payment_obj->setVuzId($request_obj->getVuzId());
                $payment_obj->setCreatedAtTs(time());
                $payment_obj->setRequestId($request_id);

                $payment_obj->save();

                //\Cebera\Helpers::redirect('/vuz/finrequest/' . $request_obj->getId() . '/fill');
            }
        }

        $content = \Cebera\Render\Render::callLocaltemplate("templates/request_payments_page.tpl.php", array('request_id' => $request_id));
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

    static public function getFinRequestsUrl(){
        return '/guk/requests';
    }

    public function finRequestsPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/fin_requests_page.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }

}