<?php

namespace Admin\Pages\Admin;


class ControllerAdmin
{
    static public function adminAction($mode){
        $self_url = '/admin';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        ob_start();
        //UserTemplate::render($user_id);
        $content = ob_get_clean();

        \Admin\Pages\AdminLayoutTemplate::render($content);
    }
}