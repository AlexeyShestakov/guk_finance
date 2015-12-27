<?php

namespace Cebera\Tree;


class Helpers {

    public static function getItemObjectForOutput($model_class_name, $obj_id){

        $obj = $model_class_name::factory($obj_id);
        \Cebera\Helpers::assert($obj);

        $output_obj = new \stdClass();

        $output_obj->id = $obj->getId();
        $output_obj->weight = $obj->getWeight();
        $output_obj->parent_id = $obj->getParentId();
        $output_obj->text = $obj->getName();

        return $output_obj;
    }

} 