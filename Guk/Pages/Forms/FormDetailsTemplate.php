<?php

namespace Guk\Pages\Forms;

use Guk\Pages\Forms\FormsController;
use Cebera\BT;

class FormDetailsTemplate
{
    const MODAL_EDIT_COL = 'MODAL_EDIT_COL';
    const FIELD_COL_TITLE = 'FIELD_COL_TITLE';
    const FIELD_COL_ID = 'FIELD_COL_ID';
    const OPERATION_DELETE_DETAIL_COL = 'OPERATION_DELETE_DETAIL_COL';
    const OPERATION_EDIT_DETAIL_COLUMN = 'OPERATION_EDIT_DETAIL_COLUMN';

    static public function render($form_id){
        $self_actions_url = FormsController::docsAction(1, $form_id);
        $form_obj = \Guk\FinForm::factory($form_id);

        echo BT::pageHeader_plain('<a href="' . FormsController::formsAction(1) . '">Формы</a> / ' . \Guk\Helpers::replaceEmptyString($form_obj->getComment()));

        \Guk\Pages\Forms\FormTabsTemplate::render($form_id);

        echo BT::toolbar_plain(
            BT::operationButton($self_actions_url, FormsController::OPERATION_ADD_DETAIL_COLUMN, 'Добавить колонку детализации')
        );

        $detail_cols_ids_arr = \Guk\DetailColumn::getDetailColumnIdsArrForFormById($form_id);

        echo BT::beginTable();

        foreach ($detail_cols_ids_arr as $detail_col_id){
            $detail_col_obj = \Guk\DetailColumn::factory($detail_col_id);

            echo BT::beginTr();

            echo BT::td_plain(
                BT::modalToggleLink(
                    self::MODAL_EDIT_COL,
                    \Guk\Helpers::replaceEmptyString($detail_col_obj->getTitle()),
                    array(
                        'data-title' => $detail_col_obj->getTitle(),
                        'data-col_id' => $detail_col_obj->getId(),
                        )
                )
            );

            echo BT::td_plain(
                BT::operationButton(
                    $self_actions_url,
                    self::OPERATION_DELETE_DETAIL_COL,
                    'Удалить',
                    array(self::FIELD_COL_ID => $detail_col_id)
                )
            );

            echo BT::endTr();
        }

        echo BT::endTable();

        echo BT::beginModalForm(self::MODAL_EDIT_COL, 'Редактирование колонки', $self_actions_url, self::OPERATION_EDIT_DETAIL_COLUMN);
        echo BT::hiddenInput(self::FIELD_COL_ID, '');
        echo BT::formGroup('Название', BT::formInput(self::FIELD_COL_TITLE, ''));
        echo BT::endModalForm();

        ?>

        <script>
            $('#<?= self::MODAL_EDIT_COL ?>').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('title');
                var col_id = button.data('col_id');
                var modal = $(this);
                modal.find('.modal-body #FIELD_COL_TITLE').val(title);
                modal.find('.modal-body #FIELD_COL_ID').val(col_id);
                })
        </script>

        <?php
    }
}