<h1>Создание формы</h1>


<form style="background-color: #eee; padding: 20px;" class="form-horizontal" method="post" action="<?php echo \Guk\GukPages\ControllerFinFormsPage::getFinFormAddPageUrl(); ?>">
    <input type="hidden" name="a" value="add_form">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Название формы</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="comment" value="">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Сохранить</button>
        </div>
    </div>

</form>
