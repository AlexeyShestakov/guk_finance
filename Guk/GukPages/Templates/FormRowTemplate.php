<?php

namespace Guk\GukPages\Templates;

class FormRowTemplate
{
    const FIELD_NAME_WEIGHT = 'weight';
    const FIELD_NAME_LIMIT = 'limit';
    const FIELD_NAME_KBK = 'kbk';
    const ADD_TERM_MODAL_ID = 'add_term';

    static public function render($row_id)
    {
        $row_obj = \Guk\FinFormRow::factory($row_id);

        $form_id = $row_obj->getFormId();
        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::h1_plain(
            \Cebera\BT::a(\Guk\GukPages\ControllerForms::getFinFormsPageUrl(), 'Формы') . ' / ' .
            \Cebera\BT::a(\Guk\GukPages\ControllerForms::formUrl($form_id), \Guk\Helpers::replaceEmptyString($form_obj->getComment())) . ' / ' .
            'Строка'
        );

        echo \Cebera\BT::beginForm(\Guk\GukPages\ControllerForms::getFinFormRowUrl($row_obj->getId()), \Guk\GukPages\ControllerForms::EDIT_ROW_OPERATION_CODE);

        echo \Cebera\BT::formGroup('Вес', '<input class="form-control" name="' . self::FIELD_NAME_WEIGHT . '" value="' . $row_obj->getWeight() . '">');
        echo \Cebera\BT::formGroup('Лимит', '<input class="form-control" name="' . self::FIELD_NAME_LIMIT . '" value="' . $row_obj->getLimit() . '"><span id="helpBlock" class="help-block">Лимит бюджетного финансирования по этой строке.</span>');
        echo \Cebera\BT::formGroup('Лимит', '<input class="form-control" name="' . self::FIELD_NAME_KBK . '" value="' . $row_obj->getKbk() . '"><span id="helpBlock" class="help-block">Код бюджетной классификации для этой строки, используется в отчетах.</span>');
        echo \Cebera\BT::formSubmit();

        echo \Cebera\BT::endForm();



        echo \Cebera\BT::div_plain(\Cebera\BT::modalToggleButton(self::ADD_TERM_MODAL_ID, 'Добавить терм'));




        $row_to_term_ids = \Guk\FormRowTermId::getIdsArrForFormRow($row_id);

        foreach ($row_to_term_ids as $row_to_term_id) {
            $row_to_term_obj = \Guk\FormRowTermId::factory($row_to_term_id);
            $term_id = $row_to_term_obj->getTermId();
            $term_obj = \Guk\Term::factory($term_id);
            echo \Cebera\BT::div_plain($term_obj->getTitle());
        }




        echo \Cebera\BT::beginModal(self::ADD_TERM_MODAL_ID, 'Назначение терма') .
            \Cebera\BT::beginForm(\Guk\GukPages\ControllerForms::getFinFormRowUrl($row_id), \Guk\GukPages\ControllerTerms::ADD_TERM_OPERATION_CODE);

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
                echo '<li><a href="' . \Guk\GukPages\ControllerForms::getFinFormRowUrl($row_id) . '?a=add_term&term_id=' . $term_id . '">' . $term_obj->getTitle() . '</a></li>';
            }

            echo '</ul>';
        }

        echo \Cebera\BT::endModalBody();

        echo \Cebera\BT::modalFooterCloseAndSubmit() .
            \Cebera\BT::endForm() .
            \Cebera\BT::endModal();
    }
}