<?php
/**
 * create table fin_form_cell (id int not null auto_increment primary key, col_id int not null, row_id int not null, value varchar(255) not null default '') default charset = utf8;
 */

namespace Guk;


class FinFormCell implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_form_cell';

    public $id = 0;
    public $row_id;
    public $col_id;
    public $value = '';

    public function getId(){
        return $this->id;
    }

    public function getRowId(){
        return $this->row_id;
    }

    public function getColId(){
        return $this->col_id;
    }

    public function setRowId($row_id){
        $this->row_id = $row_id;
    }

    public function setColId($col_id){
        $this->col_id = $col_id;
    }

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }

    // TODO: move to factory
    /**
     * @param $row_id
     * @param $col_id
     * @return \Guk\FinFormCell|null
     */
    static public function getObjForRowAndCol($row_id, $col_id){
        $cell_id = \Cebera\DB\DBWrapper::readField(\Cebera\Conf::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\FinFormCell::DB_TABLE_NAME . ' where row_id = ? and col_id = ?',
            array($row_id, $col_id)
            );

        if (!$cell_id){
            return null;
        }

        return \Guk\FinFormCell::factory($cell_id);
    }
}
