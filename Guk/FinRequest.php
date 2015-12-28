<?php

/**
 * create table fin_request(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '') default charset = utf8;
 * alter table fin_request add column vuz_id int not null;
 * alter table fin_request add column fin_form_id int not null;
 * alter table fin_request add column status_code int not null default 0;
 */

namespace Guk;

class FinRequest implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
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
}
