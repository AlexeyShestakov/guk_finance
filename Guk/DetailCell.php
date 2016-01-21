<?php
/**
 * create table detail_cell (id int not null auto_increment primary key, detail_column_id int not null, detail_row_id int not null, value varchar(1024) not null default '') default charset = utf8;
 */

namespace Guk;


class DetailCell implements \Cebera\Model\InterfaceFactory
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Conf::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'detail_cell';

    protected $id = 0;
    protected $detail_column_id;
    protected $detail_row_id;
    protected $value = '';

    public function getId(){
        return $this->id;
    }

    public function getDetailColumnId(){
        return $this->detail_column_id;
    }

    public function setDetailColumnId($detail_column_id){
        $this->detail_column_id = $detail_column_id;
    }

    public function getDetailRowId(){
        return $this->detail_row_id;
    }

    public function setDetailRowId($detail_row_id){
        $this->detail_row_id = $detail_row_id;
    }

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }

    /**
     * @param $row_id
     * @param $col_id
     * @return \Guk\FinFormCell|null
     */
    static public function getObjForRowAndCol($detail_row_id, $detail_column_id){
        $cell_id = \Cebera\DB\DBWrapper::readField(\Cebera\Conf::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\DetailCell::DB_TABLE_NAME . ' where detail_row_id = ? and detail_column_id = ?',
            array($detail_row_id, $detail_column_id)
        );

        if (!$cell_id){
            return null;
        }

        return \Guk\DetailCell::factory($cell_id);
    }

}

