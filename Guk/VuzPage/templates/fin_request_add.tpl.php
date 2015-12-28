<?php
/**
 * @var $request_id
 */

$form_id = \Guk\FinFormHelper::getCurrentFormId();

$form_obj = \Guk\FinForm::factory($form_id);

?>

<h1>Создание заявки</h1>


<form style="background-color: #eee; padding: 20px;" class="form-horizontal" method="post" action="/vuz/finrequest">
    <input type="hidden" name="a" value="add_request">
    <input type="hidden" name="fin_form_id" value="<?php echo $form_id; ?>">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Название заявки</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="title" value="">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Сохранить</button>
        </div>
    </div>

</form>

<p>Форма: <?php echo $form_obj->getComment(); ?></p>
