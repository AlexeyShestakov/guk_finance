<?php

namespace Cebera\KeyValue;

class Helper {
    /**
     * Возвращает value элемента с указанным fullname.
     * @param $fullname
     * @return string Empty string if no value.
     */
    public static function getValueByFullName($fullname){
        $item_id = \Cebera\KeyValue\ItemFactory::getItemIdByFullname($fullname);
        if (!$item_id){
            return '';
        }

        $item_obj = \Cebera\KeyValue\ItemFactory::loadItem($item_id);
        \Cebera\Helpers::assert($item_obj);

        return $item_obj->getValue();
    }

    /**
     * Возвращает массив пар ключ-значение внутри указанного контейнера в порядке их весов.
     * @param $fullname string
     * @return array
     */
    public static function getChildrenNameAndValuesArrByFullname($fullname){
        $container_id = \Cebera\KeyValue\ItemFactory::getItemIdByFullname($fullname);
        if (!$container_id){
            return array();
        }

        $container_obj = \Cebera\KeyValue\ItemFactory::loadItem($container_id);
        \Cebera\Helpers::assert($container_obj);

        $children_ids_arr = $container_obj->getChildrenIdsArr();

        $out_arr = array();

        foreach ($children_ids_arr as $child_id){
            $child_obj = \Cebera\KeyValue\ItemFactory::loadItem($child_id);
            \Cebera\Helpers::assert($child_obj);

            $out_arr[$child_obj->getName()] = $child_obj->getValue();
        }

        return $out_arr;
    }
}