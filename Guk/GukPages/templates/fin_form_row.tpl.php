<?php
/**
 * @var $row_id
 */

$row_obj = \Guk\FinFormRow::factory($row_id);

$form_id = $row_obj->getFormId();
$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::getFinFormsPageUrl(); ?>">Формы</a> / <a href="<?php echo \Guk\GukPages\ControllerFinFormsPage::getFinFormPageUrl($form_id); ?>"><?php echo \Cebera\Helpers::replaceEmptyValue($form_obj->getComment()); ?></a> / Строка</h1>

<div>&nbsp;</div>

<form class="form-horizontal" method="post" action="<?php echo \Guk\GukPages\ControllerFinFormsPage::getFinFormRowUrl($row_obj->getId()); ?>">
    <input type="hidden" name="a" value="edit_row">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Вес</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="weight" value="<?php echo $row_obj->getWeight(); ?>">
        </div>

    </div>

    <div class="form-group">
        <label for="exampleInputEmail2" class="col-sm-2 control-label">Лимит</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail2" name="limit" value="<?php echo $row_obj->getLimit(); ?>">
            <span id="helpBlock" class="help-block">Лимит бюджетного финансирования по этой строке.</span>

        </div>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail2" class="col-sm-2 control-label">КБК</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail2" name="kbk" value="<?php echo $row_obj->getKbk(); ?>">
            <span id="helpBlock" class="help-block">Код бюджетной классификации для этой строки, используется в отчетах.</span>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="form-control btn btn-primary">Сохранить</button>
        </div>
    </div>

</form>

