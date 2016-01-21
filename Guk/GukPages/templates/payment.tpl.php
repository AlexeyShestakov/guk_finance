<?php
/**
 * @var $payment_id
 */

$payment_obj = \Guk\VuzPayment::factory($payment_id);

?>

<h1><a href="<?php echo \Guk\GukPages\ControllerPayments::paymentsUrl(); ?>">Платежи</a> / <?php echo \Cebera\Helpers::replaceEmptyValue($payment_obj->getTitle()); ?></h1>

<div>&nbsp;</div>

<form class="form-horizontal" method="post" action="<?php echo \Guk\GukPages\ControllerPayments::paymentUrl($payment_obj->getId()); ?>">
    <input type="hidden" name="a" value="edit_payment">

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Название</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="title" value="<?php echo $payment_obj->getTitle(); ?>">
        </div>

    </div>

    <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-2 control-label">Сумма в рублях</label>
        <div class="col-sm-10">
            <input class="form-control" id="exampleInputEmail1" name="amount_rub" value="<?php echo $payment_obj->getAmountRub(); ?>">
        </div>

    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Статус заявки</label>
        <div class="col-sm-10">
            <input class="form-control" name="" value="<?php echo \Guk\VuzPayment::getStatusStrForCode($payment_obj->getStatusCode()); ?>" readonly/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="form-control btn btn-primary">Сохранить</button>
        </div>
    </div>

    <?php

    if ($payment_obj->getStatusCode() == \Guk\VuzPayment::STATUS_DRAFT) {
        ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="form-control btn btn-success" data-toggle="modal" data-target="#sendToVuzModal">Отправить в ВУЗ</button>
            </div>
        </div>

        <?php

    }

    ?>

</form>


<div class="modal fade" id="sendToVuzModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= \Guk\GukPages\ControllerPayments::paymentUrl($payment_obj->getId()) ?>">
                <input type="hidden" name="a" value="set_payment_status_code"/>
                <input type="hidden" name="status_code" value="<?= \Guk\VuzPayment::STATUS_SENT_TO_VUZ ?>"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Отправка платежа в ВУЗ</h4>
                </div>
                <div class="modal-body">
                    <p>Оставьте комментарий.</p>
                    <input class="form-control" name="comment" placeholder="Комментарий">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <input type="submit" class="btn btn-default btn-success" value="Принять"/>
                </div>
            </form>
        </div>
    </div>
</div>