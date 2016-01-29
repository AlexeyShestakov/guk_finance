<?php

namespace Admin\Pages\Users;

use Cebera\BT;

class ControllerUsers
{
    static public function usersAction($mode){
        $self_url = '/admin/users';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        //

        \Cebera\BT::matchOperation(UsersTemplate::OPERATION_ADD_USER, function() {
            $new_user = new \Guk\User();
            $new_user->setLogin(BT::getPostValue(UsersTemplate::FIELD_LOGIN));
            $new_user->setPassword(BT::getPostValue(UsersTemplate::FIELD_PASSWORD));
            $new_user->save();

            \OLOG\Helpers::redirect(self::usersAction(1));
        });

        //

        ob_start();
        UsersTemplate::render();
        $content = ob_get_clean();

        \Admin\Pages\AdminLayoutTemplate::render($content);
    }

    static public function userAction($mode, $user_id){
        $self_url = '/admin/user/' . $user_id;
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        //

        BT::matchOperation(UserTemplate::OPERATION_EDIT_USER, function() use($user_id){
            $user_obj = \Guk\User::factory($user_id);

            $user_obj->setLogin(BT::getPostValue(UserTemplate::FIELD_LOGIN));
            $user_obj->setPassword(BT::getPostValue(UserTemplate::FIELD_PASSWORD));
            $user_obj->setCanAccessGuk(BT::getPostValue(UserTemplate::FIELD_GUK_ACCESS));
            $user_obj->setVuzId(BT::getPostValue(UserTemplate::FIELD_VUZ_ID));

            $user_obj->save();

            \OLOG\Helpers::redirect(self::userAction(1, $user_id));
        });

        //

        ob_start();
        UserTemplate::render($user_id);
        $content = ob_get_clean();

        \Admin\Pages\AdminLayoutTemplate::render($content);
    }
}