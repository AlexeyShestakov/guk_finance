<?php
/**
 * create table detail_cell (id int not null auto_increment primary key, detail_column_id int not null, detail_row_id int not null, value varchar(1024) not null default '') default charset = utf8 engine = InnoDB;
 * alter table detail_cell add foreign key (detail_row_id) references detail_row(id);
 * alter table detail_cell add foreign key (detail_row_id) references detail_rows(id);
 * alter table detail_cell add column term_id int not null default 0;
 */

namespace Guk;


class DetailCell implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'detail_cell';

    protected $id = 0;
    protected $detail_column_id;
    protected $detail_row_id;
    protected $value = '';
    protected $term_id = 0;

    /**
     * @return int
     */
    public function getTermId()
    {
        return $this->term_id;
    }

    /**
     * @param int $term_id
     */
    public function setTermId($term_id)
    {
        $this->term_id = $term_id;
    }

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
        if ($this->getTermId()){
            $term_obj = \Guk\Term::factory($this->getTermId());
            return $term_obj->getTitle();
        }

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
        $cell_id = \OLOG\DB\DBWrapper::readField(\AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\DetailCell::DB_TABLE_NAME . ' where detail_row_id = ? and detail_column_id = ?',
            array($detail_row_id, $detail_column_id)
        );

        if (!$cell_id){
            return null;
        }

        return \Guk\DetailCell::factory($cell_id);
    }

    static public function getIdsArrForRequestAndFormRowAndTermAndCol($request_id, $form_row_id, $term_id, $detail_col_id){
        $ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\DetailCell::DB_TABLE_NAME . '
            where detail_row_id in (select id from detail_rows where request_id = ? and form_row_id = ?)
            and detail_column_id = ? and term_id = ?',
            array($request_id, $form_row_id, $detail_col_id, $term_id)
        );

        return $ids_arr;
    }

}

