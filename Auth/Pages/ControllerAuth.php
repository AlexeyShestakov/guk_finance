<?php

namespace Auth\Pages;

use Cebera\BT;

class ControllerAuth
{
    static public function authAction($mode){
        $self_url = '/auth';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'login'){
                $user_obj = \Guk\User::getObjForLoginAndPassword(BT::getPostValue('login'), BT::getPostValue('password'));
                if ($user_obj){
                    if ($user_obj->getCanAccessGuk()){
                        \Guk\User::storeCurrentOperatorUserId($user_obj->getId());
                        \OLOG\Helpers::redirect(\Guk\Pages\Forms\FormsController::formsAction(1));
                    }

                    if ($user_obj->getVuzId()){
                        \Guk\User::storeCurrentOperatorUserId($user_obj->getId());
                        \OLOG\Helpers::redirect(\Vuz\Pages\Requests\RequestsController::requestsAction(1));
                    }
                }
            }
        }

        $content = ' <div style="text-align: center;" >

        <h2 style="padding-bottom: 30px;">Финансовое планирование</h2>

        <form action="' . self::authAction(1) . '" method="post" style="max-width: 330px; margin: 0 auto;">
            <input type="hidden" name="a" value="login">
            <div><input class="form-control" name="login" placeholder="Логин"/></div>
            <div><input class="form-control" name="password" placeholder="Пароль"/></div>
            <div>&nbsp;</div>
            <div><input class="form-control btn btn-primary" type="submit" value="Войти"/></div>
        </form>

    </div>

';

        \Auth\Pages\EntryTemplate::render($content);

    }

}