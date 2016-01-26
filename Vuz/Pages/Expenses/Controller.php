<?php

namespace Vuz\Pages\Expenses;

class Controller
{
    const OPERATION_CODE_EDIT_EXPENCE = 'OPERATION_CODE_EDIT_EXPENCE';

    static public function expensesUrl(){
        return '/vuz/expenses';
    }

    static public function expensesAction(){
        $vuz_id = 1; // TODO: get from session

        \Cebera\BT::matchOperation(
            \Vuz\Pages\Expenses\Controller::OPERATION_CODE_EDIT_EXPENCE,
            function() use($vuz_id){self::editExpenseOperation($vuz_id);}
        );

        ob_start();
        \Vuz\Pages\Expenses\ExpensesTemplate::render($vuz_id);
        $content = ob_get_clean();

        \Vuz\Pages\VuzLayoutTemplate::render($content);
    }

    static public function editExpenseOperation($vuz_id){
        $form_row_id = \Cebera\BT::getPostValue(\Vuz\Pages\Expenses\ExpensesTemplate::FIELD_NAME_FORM_ROW_ID);
        $expenses_rub = \Cebera\BT::getPostValue(\Vuz\Pages\Expenses\ExpensesTemplate::FIELD_NAME_EXPENSES);

        $expenses_obj = \Guk\VuzExpenses::getObjForVuzAndFormRow($vuz_id, $form_row_id);
        if (!$expenses_obj){
            $expenses_obj = new \Guk\VuzExpenses();
            $expenses_obj->setFormRowId($form_row_id);
            $expenses_obj->setVuzId($vuz_id);
        }

        $expenses_obj->setExpensesRub($expenses_rub);
        $expenses_obj->save();

        \OLOG\Helpers::redirect(self::expensesUrl());
    }
}