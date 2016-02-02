<?php

/**
 * create table vocabulary(id int not null auto_increment primary key, created_at_ts int not null default 0, created_by_user_id int not null default 0, title varchar(250) not null default '') default charset = utf8 engine = InnoDB;
 */

namespace Guk;

class Vocabulary implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'vocabulary';

    protected $id;
    protected $title = '';
    protected $created_by_user_id = 0;
    protected $created_at_ts = 0;

    public function __construct(){
        $this->created_at_ts = time();
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

    public function getCreatedAtTs(){
        return $this->created_at_ts;
    }

    static public function getAllVocabulariesIdsArrByTitle(){
        $vocabularies_ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . \Guk\Vocabulary::DB_TABLE_NAME . ' order by title'
        );

        return $vocabularies_ids_arr;
    }

    public function getTermsJsonStr(){
        $term_ids_arr = \Guk\Term::getTermIdsArrForVocabularyByTitle($this->getId());

        $terms_arr = array(array('value' => 0, 'text' => 'не выбран'));

        foreach ($term_ids_arr as $term_id){
            $term_obj = \Guk\Term::factory($term_id);
            $terms_arr[] = array('value' => $term_id, 'text' => $term_obj->getTitle());

        }

        return json_encode($terms_arr);
    }
}