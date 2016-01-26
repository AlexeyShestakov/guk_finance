<?php

namespace Guk\Pages\Terms;

class VocabularyTemplate
{
    const ADD_TERM_MODAL_ID = 'ADD_TERM_MODAL_ID';
    const DELETE_VOCABULARY_MODAL_ID = 'DELETE_VOCABULARY_MODAL_ID';
    const RENAME_VOCABULARY_MODAL_ID = 'RENAME_VOCABULARY_MODAL_ID';

    const FIELD_NAME_VOCABULARY_TITLE = 'FIELD_NAME_VOCABULARY_TITLE';

    static public function render($vocabulary_id){
        $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);
        echo \Cebera\BT::h1_plain(\Cebera\BT::a(\Guk\Pages\Terms\ControllerTerms::vocabulariesUrl(), 'Словари') . ' / ' . $vocabulary_obj->getTitle());

        echo \Cebera\BT::div_plain(
            \Cebera\BT::modalToggleButton(self::ADD_TERM_MODAL_ID, 'Создать терм') .
            \Cebera\BT::modalToggleButton(self::DELETE_VOCABULARY_MODAL_ID, 'Удалить словарь') .
            \Cebera\BT::modalToggleButton(self::RENAME_VOCABULARY_MODAL_ID, 'Переименовать словарь')
        );

        echo \Cebera\BT::div_plain('&nbsp;');

        $terms_ids_arr = \Guk\Term::getTermIdsArrForVocabularyByTitle($vocabulary_id);
        echo \Cebera\BT::beginTable();
        foreach ($terms_ids_arr as $term_id){
            $term_obj = \Guk\Term::factory($term_id);
            echo \Cebera\BT::tr_plain(
                \Cebera\BT::td($term_obj->getTitle())
            );
        }
        echo \Cebera\BT::endTable();

        // MODALS

        echo \Cebera\BT::beginModal(self::ADD_TERM_MODAL_ID, 'Создание терма') .
            \Cebera\BT::beginForm(\Guk\Pages\Terms\ControllerTerms::vocabularyUrl($vocabulary_id), \Guk\Pages\Terms\ControllerTerms::ADD_TERM_OPERATION_CODE) .
            \Cebera\BT::beginModalBody() .
            \Cebera\BT::formGroup('Название', '<input class="form-control" name="title" value="">') .
            \Cebera\BT::endModalBody() .
            \Cebera\BT::modalFooterCloseAndSubmit() .
            \Cebera\BT::endForm() .
            \Cebera\BT::endModal();

        echo \Cebera\BT::beginModal(self::DELETE_VOCABULARY_MODAL_ID, 'Удаление словаря') .
            \Cebera\BT::beginForm(\Guk\Pages\Terms\ControllerTerms::vocabularyUrl($vocabulary_id), \Guk\Pages\Terms\ControllerTerms::DELETE_VOCABULARY_OPERATION_CODE) .
            \Cebera\BT::beginModalBody() .
            \Cebera\BT::div_plain('Вы действительно хотите удалить словарь?') .
            \Cebera\BT::endModalBody() .
            \Cebera\BT::modalFooterCloseAndSubmit() .
            \Cebera\BT::endForm() .
            \Cebera\BT::endModal();

        echo \Cebera\BT::beginModal(self::RENAME_VOCABULARY_MODAL_ID, 'Переименование словаря') .
            \Cebera\BT::beginForm(\Guk\Pages\Terms\ControllerTerms::vocabularyUrl($vocabulary_id), \Guk\Pages\Terms\ControllerTerms::RENAME_VOCABULARY_OPERATION_CODE) .
            \Cebera\BT::beginModalBody() .
            \Cebera\BT::formGroup('Название словаря', '<input class="form-control" name="' . self::FIELD_NAME_VOCABULARY_TITLE . '" value="' . $vocabulary_obj->getTitle() . '">') .
            \Cebera\BT::endModalBody() .
            \Cebera\BT::modalFooterCloseAndSubmit() .
            \Cebera\BT::endForm() .
            \Cebera\BT::endModal();
    }

}