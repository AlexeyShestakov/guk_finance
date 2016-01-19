<?php

namespace Guk;

/**
 * create table vuz_payment(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '', amount_rub int) default charset = utf8;
 * alter table vuz_payment add column fin_request_id int not null;
 * alter table vuz_payment add column vuz_id int not null;
 * alter table vuz_payment add column status_code int not null default 0;
 */

class VuzPayment implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'vuz_payment';

    public $id = 0;
    public $created_at_ts = 0;
    public $created_by_user_id = 0;
    public $title = '';
    public $vuz_id;
    public $fin_request_id;
    public $amount_rub = 0;
    public $status_code = 1;

    const STATUS_UNKNOWN = 0;
    const STATUS_DRAFT = 1;
    const STATUS_SENT_TO_VUZ = 2;
    const STATUS_RECEIVED_BY_VUZ = 3;

    static public function getStatusStrForCode($code){
        $status_arr = [
            0 => 'не указан',
            1 => 'черновик',
            2 => 'отправлен в ВУЗ',
            3 => 'получен ВУЗом'
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
        $payment_ids_arr = \Cebera\DB\DBWrapper::readColumn(
            \Cebera\Conf::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\VuzPayment::DB_TABLE_NAME. ' order by created_at_ts desc',
            array()
        );

        return $payment_ids_arr;
    }

}
