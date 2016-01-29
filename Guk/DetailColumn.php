<?php
/**
 * create table detail_columns(id int not null auto_increment primary key, title varchar(255) not null) default charset UTF8 engine = InnoDB;
 * alter table detail_columns add column is_requested_sum bool not null default false;
 * alter table detail_columns add column form_id int not null;
 * alter table detail_columns add foreign key (form_id) references fin_form (id);
 */

namespace Guk;


class DetailColumn implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'detail_columns';

    protected $id = 0;
    protected $title = '';
    protected $is_requested_sum = false;
    protected $form_id;

    /**
     * @return mixed
     */
    public function getFormId()
    {
        return $this->form_id;
    }

    /**
     * @param mixed $form_id
     */
    public function setFormId($form_id)
    {
        $this->form_id = $form_id;
    }

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

    static public function getDetailColumnIdsArrForFormById($form_id){
        $detail_column_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\DetailColumn::DB_TABLE_NAME. ' where form_id = ? order by id',
            array($form_id)
        );

        return $detail_column_ids_arr;
    }
}
