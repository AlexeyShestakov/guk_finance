<?php
/**
 * @var $form_id
 */

$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="<?php echo \Guk\GukPages\ControllerForms::getFinFormsPageUrl(); ?>">Формы</a>
    / <?php echo \Guk\Helpers::replaceEmptyString($form_obj->getComment()); ?></h1>

<?php echo \Cebera\Render\Render::callLocaltemplate('form_tabs.tpl.php', array('form_id' => $form_id)); ?>

<div>&nbsp;</div>

