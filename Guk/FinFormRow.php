<?php

/**
 * create table fin_form_row (id int not null auto_increment primary key, form_id int not null, weight int not null default 0) DEFAULT CHARSET=utf8;
 */

namespace Guk;

class FinFormRow implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_form_row';

    public $id = 0;
    public $form_id;
    public $weight = 0;

    public function getId(){
        return $this->id;
    }

    public function getFormId(){
        return $this->form_id;
    }
}
