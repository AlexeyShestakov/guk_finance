<?php

namespace Cebera\Logger;

class Helper 
{

    /**
     * @param $model_class_name
     * @return bool
     */
    public static function currentUserHasRightsToViewLog($model_class_name)
    {
        return \Sportbox\CRUD\Helpers::currentUserHasRightsToEditModel($model_class_name);
    }

}