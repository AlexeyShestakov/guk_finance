<?php

/**
 * create table user (id int not null primary key auto_increment, login varchar(200) not null, password varchar(200) not null) default charset UTF8 engine = InnoDB;
 * alter table user add column can_access_guk bool not null default false;
 * alter table user add column vuz_id int not null default 0;
 */

namespace Guk;

class User implements \OLOG\Model\InterfaceFactory
{
    use \OLOG\Model\FactoryTrait;
    use \OLOG\Model\ActiveRecord;
    use \OLOG\Model\ProtectProperties;

    const DB_ID = \AppConfig\Config::DB_NAME_GUK_FINANCE;
    const DB_TABLE_NAME = 'guk_user';

    const SESSIONFIELD_OPERATOR_USER_ID = 'SESSIONFIELD_OPERATOR_USER_ID';

    protected $id;
    protected $login;
    protected $password;
    protected $can_access_guk = 0;
    protected $vuz_id = 0;

    /**
     * @return int
     */
    public function getVuzId()
    {
        return $this->vuz_id;
    }

    /**
     * @param int $vuz_id
     */
    public function setVuzId($vuz_id)
    {
        $this->vuz_id = $vuz_id;
    }

    /**
     * @return int
     */
    public function getCanAccessGuk()
    {
        return $this->can_access_guk;
    }

    /**
     * @param int $can_access_guk
     */
    public function setCanAccessGuk($can_access_guk)
    {
        $this->can_access_guk = (bool) $can_access_guk;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    static public function getAllUserIdsArrByIdDesc(){
        $ids_arr = \OLOG\DB\DBWrapper::readColumn(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' order by id desc'
        );

        return $ids_arr;
    }

    /**
     * @param $login
     * @param $password
     * @return \Guk\User|null
     */
    static public function getObjForLoginAndPassword($login, $password){
        $id = \OLOG\DB\DBWrapper::readField(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from ' . self::DB_TABLE_NAME . ' where login = ? and password = ? limit 1',
            array($login, $password)
        );

        if ($id){
            return self::factory($id);
        }

        return null;
    }

    static public function getCurrentOperatorUserId(){
        $operator_user_id = $_SESSION[self::SESSIONFIELD_OPERATOR_USER_ID];
        return $operator_user_id;
    }

    static public function storeCurrentOperatorUserId($user_id){
        $_SESSION[self::SESSIONFIELD_OPERATOR_USER_ID] = $user_id;
    }
}