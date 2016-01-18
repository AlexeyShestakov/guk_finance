<?php
/**
 * @var $payment_id
 */

$payment_obj = \Guk\VuzPayment::factory($payment_id);

?>

<h1><a href="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::paymentsUrl(); ?>">Платежи</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($payment_obj->getTitle()); ?></h1>

<div>&nbsp;</div>

<form class="form-horizontal" method="post" action="<?php echo \Guk\FinFormsPage\ControllerFinFormsPage::paymentUrl($payment_obj->getId()); ?>">
    <input type="hidden" name="a" value="edit_payment">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Название</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="title" value="<?php echo $payment_obj->getTitle(); ?>">
        </div>

    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="form-control btn btn-primary">Сохранить</button>
        </div>
    </div>

</form>

