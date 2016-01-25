<?php
/**
 * @var $form_id
 */

$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="<?php echo \Guk\GukPages\ControllerForms::getFinFormsPageUrl(); ?>">Формы</a> / <?php echo $form_obj->getComment(); ?></h1>

<?php echo \Cebera\Render\Render::callLocaltemplate('form_tabs.tpl.php', array('form_id' => $form_id)); ?>

<div>&nbsp;</div>

<form class="form-horizontal" method="post" action="<?php echo \Guk\GukPages\ControllerForms::getFinFormParamsPageUrl($form_obj->getId()); ?>">
    <input type="hidden" name="a" value="edit_form">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Название формы</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="comment" value="<?php echo $form_obj->getComment(); ?>">
        </div>

    </div>

    <div class="form-group">
        <label for="exampleInputEmail2" class="col-sm-2 control-label">Дата начала приема заявок</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail2" name="requests_start_str" value="">
            <span id="helpBlock" class="help-block">До этой даты создание заявок запрещено.</span>

        </div>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail3" class="col-sm-2 control-label">Дата конца приема заявок</label>
        <div class="col-sm-4">
            <input class="form-control" id="exampleInputEmail3" name="requests_end_str" value="">
            <span id="helpBlock" class="help-block">После этой даты изменение заявок блокируется.</span>
        </div>
    </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input name="is_current" type="checkbox" <?php if ($form_obj->isCurrent()){ echo 'checked';} ?>> Текущая форма (используется для всех новых заявок)
                    </label>
                </div>
            </div>
        </div>

    <div class="form-group">
        <label for="exampleInputEmail5" class="col-sm-2 control-label">Заявка создана</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail5" name="" value="<?php echo date('d.m.Y', $form_obj->getCreatedAtTs()); ?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail6" class="col-sm-2 control-label">Автор</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail6" name="" value="<?php echo $form_obj->getCreatedByUserId(); ?>" readonly>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="form-control btn btn-primary">Сохранить</button>
        </div>
    </div>

</form>

