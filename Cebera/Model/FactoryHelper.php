<?php

namespace Cebera\Model;

class FactoryHelper
{
    public static function factory($class_name, $id_to_load, $exception_if_not_loaded = true)
    {
        $obj = \Cebera\Factory\Factory2::createAndLoadObject($class_name, $id_to_load);

        if ($exception_if_not_loaded) {
            \Cebera\Helpers::assert($obj);
        }

        return $obj;
    }

    public static function removeObjFromCacheById($class_name, $id_to_remove)
    {
        \Cebera\Factory\Factory2::removeObjectFromCache($class_name, $id_to_remove);
    }

    public static function afterUpdate($class_name, $id)
    {
        self::removeObjFromCacheById($class_name, $id);
    }

    public static function afterDelete($class_name, $id)
    {
        self::removeObjFromCacheById($class_name, $id);
    }
}
