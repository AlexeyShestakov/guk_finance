<?php

namespace Admin\Pages\Users;

use Cebera\BT;

class UserTemplate
{
    const OPERATION_EDIT_USER = 'OPERATION_EDIT_USER';
    const FIELD_LOGIN = 'FIELD_LOGIN';
    const FIELD_PASSWORD = 'FIELD_PASSWORD';
    const FIELD_GUK_ACCESS = 'FIELD_GUK_ACCESS';
    const FIELD_VUZ_ID = 'FIELD_VUZ_ID';

    static public function render($user_id){
        $user_obj = \Guk\User::factory($user_id);

        echo BT::pageHeader_plain(BT::a(ControllerUsers::usersAction(1), 'Пользователи') . ' / ' . $user_id );

        echo BT::beginForm(ControllerUsers::userAction(1, $user_id), self::OPERATION_EDIT_USER);

        echo BT::formGroup(
            'Логин',
            BT::formInput(self::FIELD_LOGIN, $user_obj->getLogin())
        );

        echo BT::formGroup(
            'Пароль',
            BT::formInput(self::FIELD_PASSWORD, $user_obj->getPassword())
        );

        echo BT::formGroup(
            'Доступ к ГУКу',
            BT::formCheckbox(self::FIELD_GUK_ACCESS, $user_obj->getCanAccessGuk())
        );

        echo BT::formGroup(
            'ID ВУЗа',
            BT::formInput(self::FIELD_VUZ_ID, $user_obj->getVuzId())
        );

        echo BT::formSubmit();

        echo BT::endForm();
    }
}