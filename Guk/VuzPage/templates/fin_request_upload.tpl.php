<?php
/**
 * @var $request_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);
$form_id = $request_obj->getFinFormId();

$form_obj = \Guk\FinForm::factory($form_id);

$col_ids_arr = $form_obj->getColIdsArrByWeight();
$row_ids_arr = $form_obj->getRowIdsArrByWeight();

?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($request_obj->getTitle()); ?></h1>

<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()); ?>">Заполнение</a></li>
    <li role="presentation"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestEditUrl($request_obj->getId()); ?>">Параметры</a></li>
    <li role="presentation" class="active"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestUploadUrl($request_obj->getId()) ?>">Обоснование</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestHistoryUrl($request_obj->getId()) ?>">История</a></li>
    <li role="presentation"><a href="<?= \Guk\VuzPage\ControllerVuz::getFinRequestPrintUrl($request_obj->getId()) ?>">Печать</a></li>
</ul>

<div>&nbsp;</div>

<form class="form-horizontal" method="post" action="/vuz/finrequest/<?php echo $request_obj->getId() ?>">
    <input type="hidden" name="a" value="edit_request">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Файл обоснования</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" value="" <?php if ($request_obj->getStatusCode() != \Guk\FinRequest::STATUS_DRAFT){ echo ' disabled '; } ?>/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" <?php if ($request_obj->getStatusCode() != \Guk\FinRequest::STATUS_DRAFT){ echo ' disabled '; } ?>>Закачать</button>
        </div>
    </div>

</form>
