<?php

namespace Guk\FormsPage;

class FormsPageController
{
    public function formsPageAction(){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/forms_page.tpl.php");
        echo \Cebera\Render\Render::callLocaltemplate("../layout.tpl.php", array('content' => $content));
    }

    public function formPageAction($form_id){
        $content = \Cebera\Render\Render::callLocaltemplate("templates/form_page.tpl.php", array('form_id' => $form_id));
        echo \Cebera\Render\Render::callLocaltemplate("../layout.tpl.php", array('content' => $content));
    }
}