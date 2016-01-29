<?php

namespace Guk\Pages\Forms;

use Guk\Pages\Forms\FormsController;

class FormRowTemplate
{
    const FIELD_NAME_WEIGHT = 'weight';
    const FIELD_NAME_LIMIT = 'limit';
    const FIELD_NAME_KBK = 'kbk';
    const ADD_TERM_MODAL_ID = 'add_term';
    const FIELD_NAME_ROW_TO_TERM_ID = 'FIELD_NAME_ROW_TO_TERM_ID';

    static public function render($row_id)
    {
        $row_obj = \Guk\FinFormRow::factory($row_id);

        $form_id = $row_obj->getFormId();
        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::pageHeader_plain(
            \Cebera\BT::a(\Guk\Pages\Forms\FormsController::formsAction(1), 'Формы') . ' / ' .
            \Cebera\BT::a(\Guk\Pages\Forms\FormsController::formAction(1, $form_id), \Guk\Helpers::replaceEmptyString($form_obj->getComment())) . ' / ' .
            'Строка'
        );

        echo \Cebera\BT::div_plain(\Cebera\BT::operationButton(FormsController::finFormRowAction(1, $row_id), FormsController::OPERATION_CODE_DELETE_ROW, 'Удалить строку'));
        echo \Cebera\BT::delimiter();

        echo \Cebera\BT::beginForm(FormsController::finFormRowAction(1, $row_obj->getId()), \Guk\GukPages\ControllerForms::OPERATION_CODE_EDIT_ROW);

        echo \Cebera\BT::formGroup('Вес', '<input class="form-control" name="' . self::FIELD_NAME_WEIGHT . '" value="' . $row_obj->getWeight() . '">');
        echo \Cebera\BT::formGroup('Лимит', '<input class="form-control" name="' . self::FIELD_NAME_LIMIT . '" value="' . $row_obj->getLimit() . '"><span id="helpBlock" class="help-block">Лимит бюджетного финансирования по этой строке.</span>');
        echo \Cebera\BT::formGroup('КБК', '<input class="form-control" name="' . self::FIELD_NAME_KBK . '" value="' . $row_obj->getKbk() . '"><span id="helpBlock" class="help-block">Код бюджетной классификации для этой строки, используется в отчетах.</span>');
        echo \Cebera\BT::formSubmit();

        echo \Cebera\BT::endForm();

        echo \Cebera\BT::h2_plain('Значения из словарей');

        echo \Cebera\BT::div_plain(\Cebera\BT::modalToggleButton(self::ADD_TERM_MODAL_ID, 'Добавить'));
        echo \Cebera\BT::delimiter();

        $row_to_term_ids_arr = \Guk\FormRowToTerm::getIdsArrForFormRow($row_id);

        if (count($row_to_term_ids_arr)) {
            echo \Cebera\BT::beginTable();

            foreach ($row_to_term_ids_arr as $row_to_term_id) {
                $row_to_term_obj = \Guk\FormRowToTerm::factory($row_to_term_id);
                $term_id = $row_to_term_obj->getTermId();
                $term_obj = \Guk\Term::factory($term_id);

                echo \Cebera\BT::beginTr();
                echo \Cebera\BT::td_plain($term_obj->getTitle());

                echo \Cebera\BT::td_plain(\Cebera\BT::operationButton(
                    FormsController::finFormRowAction(1, $row_id),
                    FormsController::OPERATION_CODE_REMOVE_ROW_TERM,
                    'Отвязать',
                    array(self::FIELD_NAME_ROW_TO_TERM_ID => $row_to_term_id))
                );

                echo \Cebera\BT::endTr();
            }

            echo \Cebera\BT::endTable();
        }


        echo \Cebera\BT::beginModal(self::ADD_TERM_MODAL_ID, 'Назначение значения из словаря');
        echo \Cebera\BT::beginForm(FormsController::finFormRowAction(1, $row_id), \Guk\Pages\Terms\ControllerTerms::ADD_TERM_OPERATION_CODE);
        echo \Cebera\BT::beginModalBody();

        $vocabularies_ids_arr = \Guk\Vocabulary::getAllVocabulariesIdsArrByTitle();
        foreach ($vocabularies_ids_arr as $vocabulary_id){
            $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);

            $collapse_id = 'collapse_' . $vocabulary_id;
            echo \Cebera\BT::div_plain('<b><a href="#" data-toggle="collapse" data-target="#' . $collapse_id . '" >' . $vocabulary_obj->getTitle() . '</a></b>');

            echo '<ul class="collapse" id="' . $collapse_id . '">';

            $term_ids_arr = \Guk\Term::getTermIdsArrForVocabularyByTitle($vocabulary_id);
            foreach ($term_ids_arr as $term_id){
                $term_obj = \Guk\Term::factory($term_id);
                echo '<li><a href="' . FormsController::finFormRowAction(1, $row_id) . '?a=add_term&term_id=' . $term_id . '">' . $term_obj->getTitle() . '</a></li>';
            }

            echo '</ul>';
        }

        echo \Cebera\BT::endModalBody();

        echo \Cebera\BT::modalFooterCloseAndSubmit() .
            \Cebera\BT::endForm() .
            \Cebera\BT::endModal();
    }
}