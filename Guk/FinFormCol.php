<?php
/**
 * create table fin_form_col (id int not null auto_increment primary key, form_id int not null, title varchar(100) not null default '', weight int not null default 0) DEFAULT CHARSET=utf8;
 * alter table fin_form_col add column is_editable_by_vuz boolean default false;
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
    public $is_editable_by_vuz = false;

    public function getId(){
        return $this->id;
    }

    public function getFormId(){
        return $this->form_id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getIsEditableByVuz(){
        return $this->is_editable_by_vuz;
    }
}
