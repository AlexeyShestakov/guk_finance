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

<?php

if ($form_obj->isHidden()){
    echo '<div class="alert alert-success" role="alert">Форма перемещена в архив.</div>';
    return;
} else {

    ?>

    <form class="form-horizontal" method="post"
          action="<?php echo \Guk\GukPages\ControllerForms::archiveUrl($form_obj->getId()); ?>">
        <input type="hidden" name="a" value="hide_form">

        <div class="form-group">
            <label for="exampleInputEmail1" class="col-sm-2 control-label">Причина</label>
            <div class="col-sm-10">
                <input class="form-control" id="exampleInputEmail1" name="comment" value=""/>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="form-control btn btn-primary">Отправить в архив</button>
            </div>
        </div>

    </form>


    <?php

}

?>