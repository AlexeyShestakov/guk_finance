<?php
/**
 * create table detail_columns(id int not null auto_increment primary key, title varchar(255) not null) default charset UTF8;
 * alter table detail_columns add column is_requested_sum bool default false;
 */

namespace Guk;


class DetailColumn implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'detail_columns';

    protected $id = 0;
    protected $title = '';
    protected $is_requested_sum = false;

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getIsRequestedSum(){
        return $this->is_requested_sum;
    }

    public function setIsRequestedSum($is_requested_sum){
        $this->is_requested_sum = $is_requested_sum;
    }

    static public function getDetailColumnIdsArrById(){
        $detail_column_ids_arr = \Cebera\DB\DBWrapper::readColumn(
            \Cebera\Conf::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\DetailColumn::DB_TABLE_NAME. ' order by id',
            array()
        );

        return $detail_column_ids_arr;
    }
}
