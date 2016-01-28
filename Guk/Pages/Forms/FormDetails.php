<?php

namespace Guk\Pages\Forms;

use Guk\Pages\Forms\FormsController;
use Cebera\BT;

class FormDetails
{
    static public function render($form_id){

        $form_obj = \Guk\FinForm::factory($form_id);

        echo BT::pageHeader_plain('<a href="' . FormsController::formsAction(1) . '">Формы</a> / ' . \Guk\Helpers::replaceEmptyString($form_obj->getComment()) . '</h1>');

        \Guk\Pages\Forms\FormTabsTemplate::render($form_id);

        echo \Cebera\BT::delimiter();

        $detail_cols_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormById($form_id);

        echo \Cebera\BT::beginTable();

        foreach ($detail_cols_ids_arr as $detail_col_id){
            $detail_col_obj = \Guk\DetailColumn::factory($detail_col_id);

            echo \Cebera\BT::beginTr();

            echo \Cebera\BT::td_plain($detail_col_obj->getTitle());

            echo \Cebera\BT::endTr();
        }

        echo \Cebera\BT::endTable();

    }
}