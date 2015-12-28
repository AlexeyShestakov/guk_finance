<?php
/**
 * @var $request_id
 */

$request_obj = \Guk\FinRequest::factory($request_id);
$form_id = $request_obj->getFinFormId();

$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1><a href="/vuz">Заявки</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($request_obj->getTitle()); ?></h1>

<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestFillUrl($request_obj->getId()); ?>">Заполнение</a></li>
    <li role="presentation" class="active"><a href="<?php echo \Guk\VuzPage\ControllerVuz::getFinRequestEditUrl($request_obj->getId()); ?>">Параметры</a></li>
    <li role="presentation"><a href="#">Обоснование</a></li>
</ul>

<form style="background-color: #eee; padding: 20px;" class="form-horizontal" method="post" action="/vuz/finrequest/<?php echo $request_obj->getId() ?>">
    <input type="hidden" name="a" value="edit_request">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Название заявки</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="title" value="<?php echo $request_obj->getTitle(); ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Сохранить</button>
        </div>
    </div>

</form>

<p>Форма: <?php echo $form_obj->getComment(); ?></p>
<p>Создана: <?php echo date('r', $request_obj->getCreatedAtTs()); ?></p>
<p>Автор: <?php echo $request_obj->getCreatedByUserId(); ?></p>
<p>Статус: <?php echo $request_obj::getStatusStrForCode($request_obj->getStatusCode()); ?></p>
