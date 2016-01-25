<?php

/**
 * create table fin_form (id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, comment text not null default '')  DEFAULT CHARSET=utf8;
 * alter table fin_form add column is_current boolean default false;
 */

namespace Guk;

class FinForm implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_form';

    protected $id = 0;
    protected $created_at_ts = 0;
    protected $created_by_user_id = 0;
    protected $comment = '';
    protected $is_current = false;
    protected $is_hidden = false;

    public function getId(){
        return $this->id;
    }

    public function getComment(){
        return $this->comment;
    }

    public function setComment($comment){
        $this->comment = $comment;
    }

    public function isCurrent(){
        return $this->is_current;
    }

    public function setIsCurrent($is_current){
        $this->is_current = $is_current;
    }

    public function isHidden(){
        return $this->is_hidden;
    }

    public function setIsHidden($is_hidden){
        $this->is_hidden = $is_hidden;
    }

    public function getCreatedAtTs(){
        return $this->created_at_ts;
    }

    public function setCreatedAtTs($created_at_ts){
        $this->created_at_ts = $created_at_ts;
    }

    public function getCreatedByUserId(){
        return $this->created_by_user_id;
    }

    public function getColIdsArrByWeight(){
        $col_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\FinFormCol::DB_TABLE_NAME . ' where form_id = ? order by weight',
            array($this->id)
        );

        return $col_ids_arr;
    }

    public function getRowIdsArrByWeight(){
        $col_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\FinFormRow::DB_TABLE_NAME . ' where form_id = ? order by weight',
            array($this->id)
        );

        return $col_ids_arr;
    }
}
