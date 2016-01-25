<?php
/**
 * @var $col_id
 */

$col_obj = \Guk\FinFormCol::factory($col_id);

$form_id = $col_obj->getFormId();
$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="<?php echo \Guk\GukPages\ControllerForms::getFinFormsPageUrl(); ?>">Формы</a> / <a href="<?php echo \Guk\GukPages\ControllerForms::formUrl($form_id); ?>"><?php echo \Cebera\Helpers::replaceEmptyValue($form_obj->getComment()); ?></a> / Колонка</h1>

<div>&nbsp;</div>

<form class="form-horizontal" method="post" action="<?php echo \Guk\GukPages\ControllerForms::getFinFormColUrl($col_obj->getId()); ?>">
    <input type="hidden" name="a" value="edit_col">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Вес</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="weight" value="<?php echo $col_obj->getWeight(); ?>">
        </div>

    </div>

    <div class="form-group">
        <label for="exampleInputEmail2" class="col-sm-2 control-label">Название</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail2" name="title" value="<?php echo $col_obj->getTitle(); ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input name="for_vuz" type="checkbox" <?php if ($col_obj->getIsEditableByVuz()){ echo 'checked';} ?>> Колонка для заполнения ВУЗом
                </label>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input name="is_requested_sum" type="checkbox" <?php if ($col_obj->getIsRequestedSum()){ echo 'checked';} ?>> Колонка для указания запрошенной суммы
                </label>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="form-control btn btn-primary">Сохранить</button>
        </div>
    </div>

</form>

