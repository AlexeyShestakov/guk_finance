<?php
/**
 * create table term(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '') default charset = utf8 engine = InnoDB;
 * alter table term add column vocabulary_id int not null;
 */

namespace Guk;


class Term implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'term';

    protected $id;
    protected $title = '';
    protected $created_by_user_id = 0;
    protected $created_at_ts = 0;
    protected $vocabulary_id = 0;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getCreatedAtTs()
    {
        return $this->created_at_ts;
    }

    public function getVocabularyId(){
        return $this->vocabulary_id;
    }

    public function setVocabularyId($vocabulary_id){
        $this->vocabulary_id = $vocabulary_id;
    }

    static public function getTermIdsArrForVocabularyByTitle($vocabulary_id){
        $term_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' where vocabulary_id = ? order by title',
            array($vocabulary_id)
        );

        return $term_ids_arr;
    }

}