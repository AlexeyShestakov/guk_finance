<?php
/**
 * @var $form_id
 */

use Guk\Pages\Forms\FormsController;

$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="<?php echo FormsController::formsAction(1); ?>">Формы</a>
    / <?php echo \Guk\Helpers::replaceEmptyString($form_obj->getComment()); ?></h1>

<?php \Guk\Pages\Forms\FormTabsTemplate::render($form_id) ?>

<div>&nbsp;</div>

