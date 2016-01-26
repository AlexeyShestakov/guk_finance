<?php
/**
 * create table vuz_expenses(id int not null auto_increment primary key, vuz_id int not null, form_row_id int not null, expenses_rub int not null default 0) default charset utf8;
 */

namespace Guk;

class VuzExpenses implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'vuz_expenses';

    public $id = 0;
    public $vuz_id;
    public $form_row_id;

    public $expenses_rub = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getVuzId()
    {
        return $this->vuz_id;
    }

    /**
     * @param mixed $vuz_id
     */
    public function setVuzId($vuz_id)
    {
        $this->vuz_id = $vuz_id;
    }

    /**
     * @return mixed
     */
    public function getFormRowId()
    {
        return $this->form_row_id;
    }

    /**
     * @param mixed $form_row_id
     */
    public function setFormRowId($form_row_id)
    {
        $this->form_row_id = $form_row_id;
    }

    /**
     * @return int
     */
    public function getExpensesRub()
    {
        return $this->expenses_rub;
    }

    /**
     * @param int $expenses_rub
     */
    public function setExpensesRub($expenses_rub)
    {
        $this->expenses_rub = $expenses_rub;
    }

    /**
     * @param $vuz_id
     * @param $form_row_id
     * @return \Guk\VuzExpenses|null
     */
    static public function getObjForVuzAndFormRow($vuz_id, $form_row_id){
        $expense_id = \OLOG\DB\DBWrapper::readField(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' where vuz_id = ? and form_row_id = ? limit 1',
            array($vuz_id, $form_row_id)
        );

        if (!$expense_id){
            return null;
        }

        return self::factory($expense_id);
    }

}