<?php

namespace Guk\MainPage;

class ControllerMainPage
{
    public function entryPageAction(){
        if (array_key_exists('a', $_POST)){
            if ($_POST['a'] == 'login'){
                $user_name = $_POST['user_name'];

                if ($user_name == 'guk'){
                    \OLOG\Helpers::redirect('/guk');
                }
                
                if ($user_name == 'vuz'){
                    \OLOG\Helpers::redirect('/vuz');
                }
            }
        }

        //echo \Cebera\Render\Render::callLocaltemplate("templates/entrypage.tpl.php");
        \Guk\MainPage\Templates\EntryTemplate::render();
    }

    public function mainPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("Templates/mainpage.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../guk_layout.tpl.php", array('content' => $content));
    }
}