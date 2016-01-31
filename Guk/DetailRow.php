<?php
/**
 * create table detail_rows(id int not null auto_increment primary key, request_id int not null, form_row_id int not null) default charset UTF8 engine = InnoDB;
 * alter table detail_rows add foreign key (request_id) references fin_request (id);
 * alter table detail_rows add foreign key (form_row_id) references fin_form_row (id);
 */

namespace Guk;


class DetailRow implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'detail_rows';

    protected $id = 0;
    protected $request_id;
    protected $form_row_id;

    public function getId(){
        return $this->id;
    }

    public function getRequestId(){
        return $this->request_id;
    }

    public function setRequestId($request_id){
        $this->request_id = $request_id;
    }

    public function getFormRowId(){
        return $this->form_row_id;
    }

    public function setFormRowId($form_row_id){
        $this->form_row_id = $form_row_id;
    }

    static public function getDetailRowIdsArrForRequestAndFormRowById($request_id, $form_row_id){
        $detail_row_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\DetailRow::DB_TABLE_NAME. ' where request_id = ? and form_row_id = ? order by id',
            array($request_id, $form_row_id)
        );

        return $detail_row_ids_arr;
    }

    public function getRequestedSum(){
        $form_row_obj = \Guk\FinFormRow::factory($this->getFormRowId());
        $form_id = $form_row_obj->getFormId();
        $form_obj = \Guk\FinForm::factory($form_id);

        $requested_sum_detail_col_id = $form_obj->getRequestedSumDetailColId();
        \OLOG\Helpers::assert($requested_sum_detail_col_id);

        $requested_sum_detail_cell_obj = \Guk\DetailCell::getObjForRowAndCol($this->getId(), $requested_sum_detail_col_id);
        if (!$requested_sum_detail_cell_obj){
            return 0;
        }

        return $requested_sum_detail_cell_obj->getValue();
    }
}
