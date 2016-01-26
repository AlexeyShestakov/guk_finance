<?php

namespace Vuz\Pages\Expenses;

class ExpensesTemplate
{
    const FIELD_NAME_FORM_ROW_ID = 'FIELD_NAME_FORM_ROW_ID';
    const FIELD_NAME_EXPENSES = 'FIELD_NAME_EXPENSES';

    static public function render($vuz_id){
        echo \Cebera\BT::h1_plain('Расходы');

        $form_id = \Guk\FinFormHelper::getCurrentFormId();

        if (!$form_id){
            echo '<div class="alert alert-warning" role="alert">ГУК не опубликовал форму заявки, создание заявки невозможно.</div>';
            return;
        }

        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::div_plain('Финансовый период: ' . $form_obj->getComment());
        echo \Cebera\BT::div_plain('&nbsp;');

        $form_rows_ids_arr = $form_obj->getRowIdsArrByWeight();

        echo \Cebera\BT::beginTable('table-bordered');

        echo \Cebera\BT::beginTr();
        echo \Cebera\BT::th('№');
        echo \Cebera\BT::th('Строка');
        echo \Cebera\BT::th('Перечислено ВУЗу, руб.');
        echo \Cebera\BT::th('Получено ВУЗом, руб.');
        echo \Cebera\BT::th('Израсходовано ВУЗом, руб.');
        echo \Cebera\BT::endTr();

        foreach ($form_rows_ids_arr as $form_row_id){
            $form_row_obj = \Guk\FinFormRow::factory($form_row_id);

            echo \Cebera\BT::beginTr();
            echo \Cebera\BT::td_plain($form_row_obj->getWeight());

            $form_row_obj = \Guk\FinFormRow::factory($form_row_id);

            $row_terms_str_arr = $form_row_obj->getTermsStrArr();
            $row_terms_str = implode('<br>', $row_terms_str_arr);

            echo \Cebera\BT::td_plain($row_terms_str);

            $payments_ids_arr = \Guk\VuzPayment::getIdsArrForVuzAndFormRow($vuz_id, $form_row_id);
            $sum_sent = 0;
            $sum_received = 0;

            foreach ($payments_ids_arr as $payment_id){
                $payment_obj = \Guk\VuzPayment::factory($payment_id);

                if ($payment_obj->getStatusCode() == \Guk\VuzPayment::STATUS_RECEIVED_BY_VUZ_COMPLETE){
                    $sum_sent += $payment_obj->getAmountRub();
                    $sum_received += $payment_obj->getAmountRub();
                }

                if ($payment_obj->getStatusCode() == \Guk\VuzPayment::STATUS_RECEIVED_BY_VUZ_PARTIAL){
                    $sum_sent += $payment_obj->getAmountRub();
                    $sum_received += $payment_obj->getReceivedAmountRub();
                }
            }

            echo \Cebera\BT::td($sum_sent);
            echo \Cebera\BT::td($sum_received);

            echo \Cebera\BT::beginTd();
            self::exepenseForm($vuz_id, $form_row_id);
            echo \Cebera\BT::endTd();

            echo \Cebera\BT::endTr();
        }

        echo \Cebera\BT::endTable();

        echo \Cebera\BT::div_plain('Перечеслено ВУЗу - сумма всех переведенных ВУЗу платежей по данной статье за текущий финансовый период.');
        echo \Cebera\BT::div_plain('Получено ВУЗом - сумма всех подтвержденных ВУЗом платежей по данной статье за текущий финансовый период.');
        echo \Cebera\BT::div_plain('Израсходовано ВУЗом - сумма израсходованных на текущий момент средств по данной статье.');
    }

    static public function exepenseForm($vuz_id, $form_row_id){
        $expenses_str = '';

        $expenses_obj = \Guk\VuzExpenses::getObjForVuzAndFormRow($vuz_id, $form_row_id);
        if ($expenses_obj){
            $expenses_str = $expenses_obj->getExpensesRub();
        }

        echo \Cebera\BT::beginFormSimple(
            \Vuz\Pages\Expenses\Controller::expensesUrl(),
            \Vuz\Pages\Expenses\Controller::OPERATION_CODE_EDIT_EXPENCE
        );

        echo '<input type="hidden" name="' . self::FIELD_NAME_FORM_ROW_ID . '" value="' . $form_row_id . '"/>';
        echo '<input name="' . self::FIELD_NAME_EXPENSES . '" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $expenses_str . '"/>';

        echo \Cebera\BT::endForm();
    }
}
