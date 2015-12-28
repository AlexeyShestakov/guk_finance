<?php

/**
 * create table vuz(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '') default charset = utf8;
 */

namespace Guk;

class Vuz implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'vuz';

    public $id = 0;
    public $created_at_ts = 0;
    public $created_by_user_id = 0;
    public $title = '';

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getFinRequestIdsArrByCreatedAtDesc(){
        $fin_request_ids_arr = \Cebera\DB\DBWrapper::readColumn(
            \Cebera\Conf::DB_NAME_GUK_FINANCE,
            'select id from fin_request where vuz_id = ?',
            array($this->getId())
        );

        return $fin_request_ids_arr;
    }
}
