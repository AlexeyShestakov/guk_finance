<?php

namespace Guk;

/**
 * create table vuz_payment(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '', amount_rub int not null default 0) default charset = utf8 engine = InnoDB;
 * alter table vuz_payment add column fin_request_id int not null;
 * alter table vuz_payment add column vuz_id int not null;
 * alter table vuz_payment add column status_code int not null default 0;
 * alter table vuz_payment add column form_row_id int not null;
 * alter table vuz_payment add column payments_group_id int not null;
 * alter table vuz_payment add column received_amount_rub int not null default 0;
 */

class VuzPayment implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'vuz_payment';

    protected $id = 0;
    protected $created_at_ts = 0;
    protected $created_by_user_id = 0;
    protected $title = '';
    protected $vuz_id;
    protected $fin_request_id;
    protected $amount_rub = 0;
    protected $received_amount_rub = 0;
    protected $status_code = 1;
    protected $form_row_id;
    protected $payments_group_id;

    const STATUS_UNKNOWN = 0;
    const STATUS_DRAFT = 1;
    const STATUS_IN_DFO = 2;
    const STATUS_SENT_TO_VUZ = 3;
    const STATUS_RECEIVED_BY_VUZ_COMPLETE = 4;
    const STATUS_RECEIVED_BY_VUZ_PARTIAL = 5;

    /**
     * @return int
     */
    public function getReceivedAmountRub()
    {
        return $this->received_amount_rub;
    }

    /**
     * @param int $received_amount_rub
     */
    public function setReceivedAmountRub($received_amount_rub)
    {
        $this->received_amount_rub = $received_amount_rub;
    }

    static public function getStatusStrForCode($code){
        $status_arr = [
            self::STATUS_UNKNOWN => 'не указан',
            self::STATUS_DRAFT => 'черновик',
            self::STATUS_IN_DFO => 'в ДФО',
            self::STATUS_SENT_TO_VUZ => 'отправлен в ВУЗ',
            self::STATUS_RECEIVED_BY_VUZ_COMPLETE => 'получен ВУЗом полностью',
            self::STATUS_RECEIVED_BY_VUZ_PARTIAL => 'получен ВУЗом частично'
        ];

        if (array_key_exists($code, $status_arr)){
            return $status_arr[$code];
        }

        return 'неизвестный статус: ' . $code;
    }


    public function getId(){
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPaymentsGroupId()
    {
        return $this->payments_group_id;
    }

    /**
     * @param mixed $payments_group_id
     */
    public function setPaymentsGroupId($payments_group_id)
    {
        $this->payments_group_id = $payments_group_id;
    }

    /**
     * @return mixed
     */
    public function getFormRowId()
    {
        return $this->form_row_id;
    }

    /**
     * @param mixed $form_row_id
     */
    public function setFormRowId($form_row_id)
    {
        $this->form_row_id = $form_row_id;
    }


    public function getVuzId(){
        return $this->vuz_id;
    }

    public function setVuzId($vuz_id){
        $this->vuz_id = $vuz_id;
    }

    public function getStatusCode(){
        return $this->status_code;
    }

    public function setStatusCode($status_code){
        $this->status_code = $status_code;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getAmountRub(){
        return $this->amount_rub;
    }

    public function setAmountRub($amount_rub){
        $this->amount_rub = $amount_rub;
    }

    public function getCreatedAtTs(){
        return $this->created_at_ts;
    }

    public function setCreatedAtTs($created_at_ts){
        $this->created_at_ts = $created_at_ts;
    }

    public function setRequestId($request_id){
        $this->fin_request_id = $request_id;
    }

    static public function getAllPaymentsIdsArrByCreatedAtDesc(){
        $payment_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\VuzPayment::DB_TABLE_NAME. ' order by created_at_ts desc',
            array()
        );

        return $payment_ids_arr;
    }

    static public function getIdsArrForGroupIdByCreatedAtDesc($group_id){
        $payment_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\VuzPayment::DB_TABLE_NAME. ' where payments_group_id = ? order by created_at_ts desc',
            array($group_id)
        );

        return $payment_ids_arr;
    }

    static public function getIdsArrForVuzAndFormRow($vuz_id, $form_row_id){
        $payment_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\VuzPayment::DB_TABLE_NAME. ' where vuz_id = ? and form_row_id = ?',
            array($vuz_id, $form_row_id)
        );

        return $payment_ids_arr;
    }

}
