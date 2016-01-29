<?php
/**
 * @var $form_id
 */

use Guk\Pages\Forms\FormsController;
use Cebera\BT;

$form_obj = \Guk\FinForm::factory($form_id);

echo BT::pageHeader_plain('<a href="' . FormsController::formsAction(1) . '">Формы</a> / ' . \Guk\Helpers::replaceEmptyString($form_obj->getComment()) );

\Guk\Pages\Forms\FormTabsTemplate::render($form_id);