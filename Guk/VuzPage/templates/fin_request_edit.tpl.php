<?php
/**
 * @var $request_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);
$form_id = $request_obj->getFinFormId();

$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Guk\Helpers::replaceEmptyString($request_obj->getTitle()); ?></h1>

<?php \Vuz\Pages\Requests\RequestTabs::render($request_id); ?>

<div>&nbsp;</div>

<?php

if ($request_obj->getStatusCode() == \Guk\FinRequest::STATUS_IN_GUK_REWIEW){
    echo '<div class="alert alert-info" role="alert">Заявка находится на утверждении в ГУК, изменение данных запрещено.</div>';
}

?>

<form class="form-horizontal" method="post" action="/vuz/finrequest/<?php echo $request_obj->getId() ?>">
    <input type="hidden" name="a" value="edit_request">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Название заявки</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="title" value="<?php echo $request_obj->getTitle(); ?>" <?php if ($request_obj->getStatusCode() != \Guk\FinRequest::STATUS_DRAFT){ echo ' disabled '; } ?>/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Заявка создана</label>
        <div class="col-sm-10">
            <input class="form-control" name="" value="<?php echo date('d.m.Y', $request_obj->getCreatedAtTs()); ?>" readonly/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Автор заявки</label>
        <div class="col-sm-10">
            <input class="form-control" name="" value="<?php echo $request_obj->getCreatedByUserId(); ?>" readonly/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Статус заявки</label>
        <div class="col-sm-10">
            <input class="form-control" name="" value="<?php echo $request_obj::getStatusStrForCode($request_obj->getStatusCode()); ?>" readonly/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Форма</label>
        <div class="col-sm-10">
            <input class="form-control" name="" value="<?php echo $form_obj->getComment(); ?>" readonly/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" <?php if ($request_obj->getStatusCode() != \Guk\FinRequest::STATUS_DRAFT){ echo ' disabled '; } ?>>Сохранить</button>
        </div>
    </div>

</form>
