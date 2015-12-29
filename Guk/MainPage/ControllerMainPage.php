<?php

namespace Guk\MainPage;

class ControllerMainPage
{
    public function entryPageAction(){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'login'){
                $user_name = $_POST['user_name'];

                if ($user_name == 'guk'){
                    \Cebera\Helpers::redirect('/guk');
                }
                
                if ($user_name == 'vuz'){
                    \Cebera\Helpers::redirect('/vuz');
                }
            }
        }

        echo \Cebera\Render\Render::callLocaltemplate("templates/entrypage.tpl.php");
    }

    public function mainPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/mainpage.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }
}