<?php

/**
 * create table fin_form_row (id int not null auto_increment primary key, form_id int not null, weight int not null default 0) DEFAULT CHARSET=utf8;
 * alter table fin_form_row add column limit_int int not null default 0;
 * alter table fin_form_row add column kbk varchar(255) not null default '';
 */

namespace Guk;

class FinFormRow implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_form_row';

    protected $id = 0;
    protected $form_id;
    protected $weight = 0;
    protected $limit_int = 0;
    protected $kbk = '';

    public function getId(){
        return $this->id;
    }

    public function getLimit(){
        return $this->limit_int;
    }

    public function setLimit($limit){
        $this->limit_int = $limit;
    }

    public function getKbk(){
        return $this->kbk;
    }

    public function setKbk($kbk){
        $this->kbk = $kbk;
    }

    public function getFormId(){
        return $this->form_id;
    }

    public function setFormId($form_id){
        $this->form_id = $form_id;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function setWeight($weight){
        $this->weight = $weight;
    }
}
