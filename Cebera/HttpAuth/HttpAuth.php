<?php

namespace Cebera\HttpAuth;

class HttpAuth
{

    static function getCurrentUserHttpAuthName(){
        if (array_key_exists('PHP_AUTH_USER', $_SERVER)) {
            return $_SERVER['PHP_AUTH_USER'];
        }

        return (\Cebera\ConfWrapper::value('forced_http_auth_user_name', ''));
    }
}