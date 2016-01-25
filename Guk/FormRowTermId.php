<?php
/**
 * create table form_row_term_id (id int unsigned not null auto_increment primary key, form_row_id int not null, term_id int not null) default charset utf8;
 * alter table form_row_term_id add unique index (form_row_id, term_id);
 */

namespace Guk;


class FormRowTermId implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'form_row_term_id';

    protected $id = 0;
    protected $form_row_id;
    protected $term_id;

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
     * @return mixed
     */
    public function getTermId()
    {
        return $this->term_id;
    }

    /**
     * @param mixed $term_id
     */
    public function setTermId($term_id)
    {
        $this->term_id = $term_id;
    }

    static public function getIdsArrForFormRow($row_id){
        $ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' where form_row_id = ? order by id',
            array($row_id)
        );

        return $ids_arr;
    }

    static public function getObjForFormRowAndVocabulary($row_id, $vocabulary_id){
        $term_to_row_ids_arr = self::getIdsArrForFormRow($row_id);

        foreach ($term_to_row_ids_arr as $term_to_row_id){
            $term_to_row_obj = self::factory($term_to_row_id);
            $term_id = $term_to_row_obj->getTermId();
            $term_obj = \Guk\Term::factory($term_id);

            if ($term_obj->getVocabularyId() == $vocabulary_id){
                return $term_to_row_obj;
            }

        }

        return null;
    }

}