<?php

namespace Guk\Pages\Forms;

use Guk\Pages\Forms\FormsController;

class FormTabsTemplate
{
    static public function render($form_id){

$form_obj = \Guk\FinForm::factory($form_id);

$camn = \OLOG\Router::getCurrentActionMethodName();

?>

<ul class="nav nav-tabs">
    <li role="presentation" <?php if ($camn == FormsController::formAction(2, '')[0]) echo ' class="active" ';?> ><a href="<?php echo FormsController::formAction(1, $form_obj->getId()); ?>">Поля</a></li>
    <li role="presentation" <?php if ($camn == 'finFormParamsAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerForms::getFinFormParamsPageUrl($form_obj->getId()); ?>">Параметры</a></li>
    <li role="presentation" <?php if ($camn == FormsController::docsAction(2, '')[0]) echo ' class="active" ';?> ><a href="<?php echo FormsController::docsAction(1, $form_obj->getId()); ?>">Обоснование</a></li>
    <li role="presentation" <?php if ($camn == 'finFormViewAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerForms::getFinFormViewUrl($form_obj->getId()); ?>">Печать</a></li>
    <li role="presentation" <?php if ($camn == 'archiveAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerForms::archiveUrl($form_obj->getId()); ?>">Архив</a></li>
    <li role="presentation" <?php if ($camn == 'historyAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerForms::historyUrl($form_obj->getId()); ?>">История</a></li>
</ul>

    <?php

        echo \Cebera\BT::delimiter();

    }
}