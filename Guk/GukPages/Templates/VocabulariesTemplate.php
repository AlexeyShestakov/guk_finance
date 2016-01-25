<?php

namespace Guk\GukPages\Templates;

class VocabulariesTemplate
{
    const ADD_VOCABULARY_MODAL_ID = 'addVocabularyModal';

    static public function render(){
        echo \Cebera\BT::h1_plain('Словари');
        echo \Cebera\BT::div_plain(\Cebera\BT::modalToggleButton(self::ADD_VOCABULARY_MODAL_ID, 'Создать'));
        echo \Cebera\BT::div_plain('&nbsp;');

        echo \Cebera\BT::beginTable();

        $vocabularies_ids_arr = \Guk\Vocabulary::getAllVocabulariesIdsArrByTitle();
        foreach ($vocabularies_ids_arr as $vocabulary_id) {
            $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);

            echo \Cebera\BT::beginTr();
            echo '<td>' . \Cebera\BT::a(\Guk\GukPages\ControllerTerms::vocabularyUrl($vocabulary_obj->getId()), $vocabulary_obj->getTitle()) . '</td>';
            echo \Cebera\BT::td(date('d.m.Y', $vocabulary_obj->getCreatedAtTs()));
            echo \Cebera\BT::endTr();
        }

        echo \Cebera\BT::endTable();

        // MODALS

        echo \Cebera\BT::beginModal(self::ADD_VOCABULARY_MODAL_ID, 'Создание словаря');
        echo \Cebera\BT::beginForm(\Guk\GukPages\ControllerTerms::vocabulariesUrl(), \Guk\GukPages\ControllerTerms::ADD_VOCABULARY_OPERATION_CODE);

        ?>

        <div class="modal-body">
            <?= \Cebera\BT::formGroup('Название', '<input class="form-control" name="title" value="">') ?>
        </div>

        <?php

        echo \Cebera\BT::modalFooterCloseAndSubmit();
        echo \Cebera\BT::endForm();
        echo \Cebera\BT::endModal();
    }

}