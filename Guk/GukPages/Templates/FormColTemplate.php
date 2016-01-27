<?php

namespace Guk\GukPages\Templates;


class FormColTemplate
{
    const FIELD_NAME_VOCABULARY_ID = 'FIELD_NAME_VOCABULARY_ID';
    const FIELD_NAME_WEIGHT = 'FIELD_NAME_WEIGHT';
    const FIELD_NAME_TITLE = 'FIELD_NAME_TITLE';

    static public function render($col_id)
    {
        $col_obj = \Guk\FinFormCol::factory($col_id);

        $form_id = $col_obj->getFormId();
        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::h1_plain(
            \Cebera\BT::a(\Guk\GukPages\ControllerForms::finFormsPageAction(1), 'Формы') . ' / ' .
            \Cebera\BT::a(\Guk\GukPages\ControllerForms::finFormPageAction(1, $form_id), \Guk\Helpers::replaceEmptyString($form_obj->getComment())) . ' / ' .
            'Колонка'
        );

        echo '<div>';

        echo \Cebera\BT::operationButton(\Guk\GukPages\ControllerForms::getFinFormColUrl($col_obj->getId()), \Guk\GukPages\ControllerForms::OPERATION_CODE_DELETE_COL, 'Удалить колонку');

        echo '</div>';
        echo \Cebera\BT::div_plain('&nbsp;');

        echo \Cebera\BT::beginForm(\Guk\GukPages\ControllerForms::getFinFormColUrl($col_obj->getId()), \Guk\GukPages\ControllerForms::OPERATION_CODE_EDIT_COL);

        echo \Cebera\BT::formGroup('Вес', '<input class="form-control" name="' . self::FIELD_NAME_WEIGHT . '" value="' . $col_obj->getWeight() . '">');
        echo \Cebera\BT::formGroup('Название', '<input class="form-control" name="' . self::FIELD_NAME_TITLE . '" value="' . $col_obj->getTitle() . '">');

        $vocabularies_ids_arr = \Guk\Vocabulary::getAllVocabulariesIdsArrByTitle();
        $vocabularies_ids_to_name_arr = array();
        foreach ($vocabularies_ids_arr as $vocabulary_id) {
            $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);
            $vocabularies_ids_to_name_arr[$vocabulary_id] = $vocabulary_obj->getTitle();
        }

        echo \Cebera\BT::formGroup('Словарь', \Cebera\BT::select(self::FIELD_NAME_VOCABULARY_ID, $vocabularies_ids_to_name_arr, $col_obj->getVocabularyId()));

        ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input name="for_vuz" type="checkbox" <?php if ($col_obj->getIsEditableByVuz()) {
                            echo 'checked';
                        } ?>> Колонка для заполнения ВУЗом
                    </label>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input name="is_requested_sum" type="checkbox" <?php if ($col_obj->getIsRequestedSum()) {
                            echo 'checked';
                        } ?>> Колонка для указания запрошенной суммы
                    </label>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="form-control btn btn-primary">Сохранить</button>
            </div>
        </div>

        <?php

        echo \Cebera\BT::endForm();

    }
}