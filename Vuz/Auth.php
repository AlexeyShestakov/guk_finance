<?php

namespace Vuz;

class Auth
{
    static public function getCurrentOperatorVuzId(){
        $operator_user_id = \Guk\User::getCurrentOperatorUserId();

        if (!$operator_user_id){
            \OLOG\Helpers::redirect('/');
        }

        $user_obj = \Guk\User::factory($operator_user_id);
        if (!$user_obj->getVuzId()){
            throw new \Exception('Пользователю не назначен ВУЗ');
        }

        return $user_obj->getVuzId();
    }

}