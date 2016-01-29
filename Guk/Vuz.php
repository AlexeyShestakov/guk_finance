<?php

/**
 * create table vuz(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '') default charset = utf8 engine = InnoDB;
 */

namespace Guk;

class Vuz implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'vuz';

    protected $id = 0;
    protected $created_at_ts = 0;
    protected $created_by_user_id = 0;
    protected $title = '';

    public function getId(){
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    public function getFinRequestIdsArrByCreatedAtDesc(){
        $fin_request_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from fin_request where vuz_id = ? order by created_at_ts desc',
            array($this->getId())
        );

        return $fin_request_ids_arr;
    }

    public function getPaymentIdsArrByCreatedAtDesc(){
        $payment_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\VuzPayment::DB_TABLE_NAME. ' where vuz_id = ? order by created_at_ts desc',
            array($this->getId())
        );

        return $payment_ids_arr;
    }

    static public function getAllIdsArrByIdDesc(){
        $ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' order by id desc'
        );

        return $ids_arr;
    }
}
