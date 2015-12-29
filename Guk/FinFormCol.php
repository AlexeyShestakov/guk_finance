<?php
/**
 * create table fin_form_col (id int not null auto_increment primary key, form_id int not null, title varchar(100) not null default '', weight int not null default 0) DEFAULT CHARSET=utf8;
 * alter table fin_form_col add column is_editable_by_vuz boolean default false;
 * alter table fin_form_col add column is_requested_sum boolean not null default false;
 */

namespace Guk;

class FinFormCol implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_form_col';

    public $id = 0;
    public $form_id;
    public $title = '';
    public $weight = 0;
    public $is_editable_by_vuz = 0;
    public $is_requested_sum = 0;

    public function getId(){
        return $this->id;
    }

    public function getIsRequestedSum(){
        return $this->is_requested_sum;
    }

    public function setIsRequestedSum($is){
        $this->is_requested_sum = $is;
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

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getIsEditableByVuz(){
        return $this->is_editable_by_vuz;
    }

    public function setIsEditableByVuz($for_vuz){
        $this->is_editable_by_vuz = $for_vuz;
    }
}
