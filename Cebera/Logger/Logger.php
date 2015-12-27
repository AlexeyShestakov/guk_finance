<?php

namespace Cebera\Logger;


class Logger implements
    \Cebera\Model\InterfaceLoad,
    \Cebera\Model\InterfaceFactory,
    \Cebera\Model\InterfaceCacheTtlSeconds
{
    use \Cebera\Model\FactoryTrait;
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Util\ProtectProperties;

    const DB_ID = \Cebera\Constants::DB_NAME_PARKFACE;
    const DB_TABLE_NAME = 'admin_log';

    protected $id = null;
    protected $user_id;
    protected $http_auth_user_name;
    protected $ts;
    protected $ip;
    protected $entity_id;
    protected $object;
    protected $action;

    /**
     * Если передан не объект, то в базе вместо идентификатора объекта будет хранится строка "not_object"
     *
     * @param $object
     * @param $action
     */
    static public function logObjectEvent($object, $action)
    {

        $entity_id = \Cebera\Helpers::getFullObjectId($object);
        $serialized_object = addslashes(serialize($object));

        $ip_address = '';
        if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        \Cebera\DB\DBWrapper::query(\Cebera\Constants::DB_NAME_PARKFACE,
            "INSERT INTO admin_log (user_id, http_auth_user_name, ts, ip, action, entity_id, object) VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?)",
            array(self::currentUserId(), self::getCurrentUserHttpAuthName(), $ip_address, $action, $entity_id, $serialized_object)
        );
    }

    static public function currentUserId()
    {
        $current_user_id = \Parkface\Helpers::getCurrentUserId();
        if ($current_user_id == '') {
            return 0;
        }
        return $current_user_id;
    }

    public static function getCurrentUserHttpAuthName()
    {
        return \Cebera\HttpAuth\HttpAuth::getCurrentUserHttpAuthName();
    }

    public function getCacheTtlSeconds()
    {
        return 60;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getHttpAuthUserName()
    {
        return $this->http_auth_user_name;
    }

    /**
     * @return mixed
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return unserialize(stripslashes($this->object));
    }

    public function getEntryHtml() {
        $html = '';
        $html .= \Cebera\Logger\ControllerLogger::renderRecordHead($this->getId());
        $html .= \Cebera\Logger\ControllerLogger::delta($this->getId());
        $html .= \Cebera\Logger\ControllerLogger::renderObjectFields($this->getId());

        return $html;
    }
}