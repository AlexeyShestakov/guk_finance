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

<h1><a href="/vuz">Заявки</a> / <?php echo \Guk\Helpers::replaceEmptyString($request_obj->getTitle()); ?></h1>

<?php \Vuz\Pages\Requests\RequestTabs::render($request_id); ?>

<div>&nbsp;</div>

<div>
    <button class="btn btn-default "><span class="glyphicon glyphicon-save-file"></span> Скачать шаблон обоснования</button>
</div>

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
            <button type="submit" class="form-control btn btn-primary" <?php if ($request_obj->getStatusCode() != \Guk\FinRequest::STATUS_DRAFT){ echo ' disabled '; } ?>>Закачать</button>
        </div>
    </div>

</form>
