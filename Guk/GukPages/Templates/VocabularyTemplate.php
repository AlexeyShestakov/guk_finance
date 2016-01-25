<?php

namespace Guk\GukPages\Templates;

class VocabularyTemplate
{
    const ADD_TERM_MODAL_ID = 'addTermModal';

    static public function render($vocabulary_id){
        $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);
        echo \Cebera\BT::h1_plain(\Cebera\BT::a(\Guk\GukPages\ControllerTerms::vocabulariesUrl(), 'Словари') . ' / ' . $vocabulary_obj->getTitle());
        echo \Cebera\BT::div_plain(\Cebera\BT::modalToggleButton(self::ADD_TERM_MODAL_ID, 'Создать терм'));
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
            \Cebera\BT::beginForm(\Guk\GukPages\ControllerTerms::vocabularyUrl($vocabulary_id), \Guk\GukPages\ControllerTerms::ADD_TERM_OPERATION_CODE) .
            \Cebera\BT::beginModalBody() .
            \Cebera\BT::formGroup('Название', '<input class="form-control" name="title" value="">') .
            \Cebera\BT::endModalBody() .
            \Cebera\BT::modalFooterCloseAndSubmit() .
            \Cebera\BT::endForm() .
            \Cebera\BT::endModal();
    }

}