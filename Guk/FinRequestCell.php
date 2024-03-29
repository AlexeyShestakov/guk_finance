<?php

/**
 * create table fin_request_cell (id int not null auto_increment primary key, fin_request_id int not null, col_id int not null, row_id int not null, value varchar(255) not null default '') default charset = utf8 engine = InnoDB;
 * alter table fin_request_cell ADD COLUMN corrected_value varchar(255) not null default '';
 */

namespace Guk;


class FinRequestCell implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_request_cell';

    protected $id = 0;
    protected $fin_request_id;
    protected $row_id;
    protected $col_id;
    protected $value = '';
    protected $corrected_value = '';

    public function getId(){
        return $this->id;
    }

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }

    public function getCorrectedValue(){
        return $this->corrected_value;
    }

    public function setCorrectedValue($corrected_value){
        $this->corrected_value = $corrected_value;
    }

    public function getFinRequestId(){
        return $this->fin_request_id;
    }

    public function setFinRequestId($fin_request_id){
        $this->fin_request_id = $fin_request_id;
    }

    public function getRowId(){
        return $this->row_id;
    }

    public function setRowId($row_id){
        $this->row_id = $row_id;
    }

    public function setColId($col_id){
        $this->col_id = $col_id;
    }

    // TODO: move to factory
    /**
     * @param $row_id
     * @param $col_id
     * @return \Guk\FinRequestCell|null
     */
    static public function getObjForRequestAndRowAndCol($fin_request_id, $row_id, $col_id){
        $cell_id = \OLOG\DB\DBWrapper::readField(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' where fin_request_id = ? and row_id = ? and col_id = ?',
            array($fin_request_id, $row_id, $col_id)
        );

        if (!$cell_id){
            return null;
        }

        return self::factory($cell_id);
    }
}
