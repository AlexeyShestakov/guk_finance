<?php

namespace Guk;

/**
 * create table vuz_payment(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '', amount_rub int) default charset = utf8;
 * alter table vuz_payment add column fin_request_id int not null;
 * alter table vuz_payment add column vuz_id int not null;
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

    public function setRequestId($request_id){
        $this->fin_request_id = $request_id;
    }
}
