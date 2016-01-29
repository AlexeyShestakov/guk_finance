<?php

/**
 * create table payments_group(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0) default charset = utf8 engine = InnoDB;
 */

namespace Guk;

class PaymentsGroup implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'payments_group';

    public $id = 0;
    public $created_at_ts = 0;
    public $created_by_user_id = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCreatedAtTs()
    {
        return $this->created_at_ts;
    }

    /**
     * @param int $created_at_ts
     */
    public function setCreatedAtTs($created_at_ts)
    {
        $this->created_at_ts = $created_at_ts;
    }

    /**
     * @return int
     */
    public function getCreatedByUserId()
    {
        return $this->created_by_user_id;
    }

    /**
     * @param int $created_by_user_id
     */
    public function setCreatedByUserId($created_by_user_id)
    {
        $this->created_by_user_id = $created_by_user_id;
    }

    static public function getIdsArrByCreatedAt(){
        $ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' order by created_at_ts desc'
        );

        return $ids_arr;
    }
}