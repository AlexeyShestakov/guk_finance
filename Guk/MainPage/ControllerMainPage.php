<?php

namespace Guk\MainPage;

class ControllerMainPage
{
    public function entryPageAction($mode){
        $self_url = '/';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        \OLOG\Helpers::redirect(\Auth\Pages\ControllerAuth::authAction(1));
    }

    public function mainPageAction(){
        \OLOG\Helpers::redirect(\Guk\Pages\Requests\ControllerRequests::getFinRequestsUrl());
    }
}