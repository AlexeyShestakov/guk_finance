<?php

/**
 * create table fin_request(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '') default charset = utf8 engine = InnoDB;
 * alter table fin_request add column vuz_id int not null;
 * alter table fin_request add column fin_form_id int not null;
 * alter table fin_request add column status_code int not null default 0;
 * alter table fin_request add foreign key (fin_form_id) references fin_form (id);
 */

namespace Guk;

class FinRequest implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_request';

    const STATUS_UNKNOWN = 0;
    const STATUS_DRAFT = 1;
    const STATUS_IN_GUK_REWIEW = 2;
    const STATUS_APPROVED_BY_GUK = 3;
    const STATUS_REJECTED_BY_GUK = 4;
    const STATUS_DISCARDED_BY_VUZ = 5;
    const STATUS_NOT_FINISHED_IN_TIME = 6;

    public $id = 0;
    public $created_at_ts = 0;
    public $created_by_user_id = 0;
    public $title = '';
    public $vuz_id;
    public $fin_form_id;
    public $status_code = 0;

    public function getCorrectedSumForRow($row_id){
        $form_id = $this->getFinFormId();
        $form_obj = \Guk\FinForm::factory($form_id);
        $requested_sum_col_id = $form_obj->getRequestedSumColId();
        $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($this->getId(), $row_id, $requested_sum_col_id);

        if ($request_cell_obj) {
            $corrected_value = $request_cell_obj->getCorrectedValue();
            if (!$corrected_value){
                $corrected_value = $request_cell_obj->getValue();
            }

            return intval($corrected_value);
        }

        return 0;
    }

    public function setCorrectedSumForRow($row_id, $corrected_value){
        $form_id = $this->getFinFormId();
        $form_obj = \Guk\FinForm::factory($form_id);
        $requested_sum_col_id = $form_obj->getRequestedSumColId();
        $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($this->getId(), $row_id, $requested_sum_col_id);

        \OLOG\Helpers::assert($request_cell_obj); // в норме такого быть не должно, мы же не корректируем отсутствующие значения?
        $request_cell_obj->setCorrectedValue($corrected_value);
        $request_cell_obj->save();
    }

    public function getRequestedSumForRow($row_id){
        $form_id = $this->getFinFormId();
        $form_obj = \Guk\FinForm::factory($form_id);
        $requested_sum_col_id = $form_obj->getRequestedSumColId();
        $request_cell_obj = \Guk\FinRequestCell::getObjForRequestAndRowAndCol($this->getId(), $row_id, $requested_sum_col_id);

        if ($request_cell_obj) {
            return intval($request_cell_obj->getValue());
        }

        return 0;
    }

    public function logChange($info, $comment = ''){
        $log_obj = new \Guk\FinRequestLog();
        $log_obj->setRequestId($this->getId());
        $log_obj->setCreatedAtTs(time());
        $log_obj->setChangeInfo($info);
        $log_obj->setComment($comment);
        $log_obj->save();
    }

    static public function getStatusStrForCode($code){
        $status_arr = [
            0 => 'не указан',
            1 => 'черновик',
            2 => 'на утверждении в ГУК',
            3 => 'утверждена ГУК',
            4 => 'отклонена ГУК',
            5 => 'отклонена ВУЗом',
            6 => 'не отправлена вовремя'
        ];

        if (array_key_exists($code, $status_arr)){
            return $status_arr[$code];
        }

        return 'неизвестный статус: ' . $code;
    }

    public function getId(){
        return $this->id;
    }

    public function getVuzId(){
        return $this->vuz_id;
    }

    public function setVuzId($vuz_id){
        $this->vuz_id = $vuz_id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getCreatedAtTs(){
        return $this->created_at_ts;
    }

    public function setCreatedAtTs($created_at_ts){
        $this->created_at_ts = $created_at_ts;
    }

    public function getStatusCode(){
        return $this->status_code;
    }

    public function setStatusCode($status_code){
        $this->status_code = $status_code;
    }

    public function getCreatedByUserId(){
        return $this->created_by_user_id;
    }

    public function getFinFormId(){
        return $this->fin_form_id;
    }

    public function setFinFormId($fin_form_id){
        $this->fin_form_id = $fin_form_id;
    }

    static public function getRequestIdsArrForFormByCreatedAtDesc($form_id){
        $requests_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\FinRequest::DB_TABLE_NAME. ' where fin_form_id = ? order by created_at_ts desc',
            array($form_id)
        );

        return $requests_ids_arr;
    }

    public function getPaymentIdsArrByCreatedAtDesc(){
        $payment_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\VuzPayment::DB_TABLE_NAME. ' where fin_request_id = ? order by created_at_ts desc',
            array($this->getId())
        );

        return $payment_ids_arr;
    }

}
