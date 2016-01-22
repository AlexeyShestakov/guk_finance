<?php

/**
 * @var $form_id
 */

$form_obj = \Guk\FinForm::factory($form_id);

$camn = \Cebera\Router::getCurrentActionMethodName();

?>

<ul class="nav nav-tabs">
    <li role="presentation" <?php if ($camn == 'finFormPageAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::getFinFormPageUrl($form_obj->getId()); ?>">Поля</a></li>
    <li role="presentation" <?php if ($camn == 'finFormParamsAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::getFinFormParamsPageUrl($form_obj->getId()); ?>">Параметры</a></li>
    <li role="presentation" <?php if ($camn == 'docsAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::docsUrl($form_obj->getId()); ?>">Обоснование</a></li>
    <li role="presentation" <?php if ($camn == 'finFormViewAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::getFinFormViewUrl($form_obj->getId()); ?>">Печать</a></li>
    <li role="presentation" <?php if ($camn == 'archiveAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::archiveUrl($form_obj->getId()); ?>">Архив</a></li>
    <li role="presentation" <?php if ($camn == 'historyAction') echo ' class="active" ';?> ><a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::historyUrl($form_obj->getId()); ?>">История</a></li>
</ul>