<?php

namespace Cebera\KeyValue;

class ItemFactory extends \Cebera\Factory\Factory2 {

    const ITEM_CLASS_NAME = '\Cebera\KeyValue\Item';

    /**
     * @param $id
     * @return null|\Cebera\KeyValue\Item
     */
    public static function loadItem($id){
        return self::createAndLoadObject(self::ITEM_CLASS_NAME, $id);
    }

    /**
     * @param $fullname
     * @return int|mixed 0 if no such item
     */
    public static function getItemIdByFullname($fullname){

        $cache_key = 'kv_fullname_to_id_' . md5($fullname);
        $cache_value = \Cebera\Cache\CacheWrapper::get($cache_key);
        if ($cache_value !== false){
            return $cache_value;
        }

        $item_id = \Cebera\DB\DBWrapper::readField(\Cebera\KeyValue\Item::DB_ID,
            "select id from " . \Cebera\KeyValue\Item::DB_TABLE_NAME . " where fullname = ?",
            array($fullname));

        $item_id = intval($item_id); // remove probable null

        \Cebera\Cache\CacheWrapper::set($cache_key, $item_id);

        return $item_id;
    }
}