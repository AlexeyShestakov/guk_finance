<?php

namespace Admin\Pages\Users;

use Cebera\BT;

class UsersTemplate
{
    const OPERATION_ADD_USER = 'OPERATION_ADD_USER';
    const MODAL_ADD_USER = 'MODAL_ADD_USER';
    const FIELD_LOGIN = 'FIELD_LOGIN';
    const FIELD_PASSWORD = 'FIELD_PASSWORD';

    static public function render(){
        echo BT::pageHeader_plain('Пользователи');

        echo BT::toolbar_plain(
            BT::modalToggleButton(self::MODAL_ADD_USER, 'Создать пользователя')
        );


        $user_ids_arr = \Guk\User::getAllUserIdsArrByIdDesc();

        echo BT::beginTable();

        foreach ($user_ids_arr as $user_id){
            $user_obj = \Guk\User::factory($user_id);

            echo BT::beginTr();
            echo BT::td_plain(
                BT::a(ControllerUsers::userAction(1, $user_id), $user_obj->getLogin())
            );
            echo BT::endTr();
        }

        echo BT::endTable();

        echo BT::beginModalForm(self::MODAL_ADD_USER, 'Создание пользователя', ControllerUsers::usersAction(1), self::OPERATION_ADD_USER);
        echo BT::formGroup('Логин', BT::formInput(self::FIELD_LOGIN));
        echo BT::formGroup('Пароль', BT::formInput(self::FIELD_PASSWORD));
        echo BT::endModalForm();
    }
}