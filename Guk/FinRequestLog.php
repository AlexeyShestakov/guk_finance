<?php

/**
 * create table fin_request_log (id int not null auto_increment primary key, request_id int not null, created_at_ts int not null, author_user_id int not null, comment varchar(1024), change_info varchar(1024)) default charset = utf8 engine = InnoDB;
 */

namespace Guk;

class FinRequestLog implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'fin_request_log';

    protected $id = 0;
    protected $request_id = 0;
    protected $created_at_ts = 0;
    protected $author_user_id = 0;
    protected $comment = '';
    protected $change_info = '';

    public function getId(){
        return $this->id;
    }

    public function getRequestId(){
        return $this->request_id;
    }

    public function setRequestId($request_id){
        $this->request_id = $request_id;
    }

    public function getCreatedAtTs(){
        return $this->created_at_ts;
    }

    public function setCreatedAtTs($created_at_ts){
        $this->created_at_ts = $created_at_ts;
    }

    public function getChangeInfo(){
        return $this->change_info;
    }

    public function setChangeInfo($change_info){
        $this->change_info = $change_info;
    }

    public function getComment(){
        return $this->comment;
    }

    public function setComment($comment){
        $this->comment = $comment;
    }


}
