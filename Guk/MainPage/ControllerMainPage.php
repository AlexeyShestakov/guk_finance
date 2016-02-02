<?php

namespace Guk\MainPage;

class ControllerMainPage
{
    static public function entryPageAction($mode){
        $self_url = '/';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        \OLOG\Helpers::redirect(\Auth\Pages\ControllerAuth::authAction(1));
    }

    static public function mainPageAction($mode){
        $self_url = '/guk';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        \OLOG\Helpers::redirect(\Guk\Pages\Requests\ControllerRequests::getFinRequestsUrl());
    }
}