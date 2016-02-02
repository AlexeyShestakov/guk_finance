<?php

namespace Guk\Pages\Terms;

class VocabulariesTemplate
{
    const ADD_VOCABULARY_MODAL_ID = 'ADD_VOCABULARY_MODAL_ID';

    static public function render(){
        echo \Cebera\BT::pageHeader_plain('Словари');
        echo \Cebera\BT::toolbar_plain(\Cebera\BT::modalToggleButton(self::ADD_VOCABULARY_MODAL_ID, 'Создать'));

        echo \Cebera\BT::beginTable();

        $vocabularies_ids_arr = \Guk\Vocabulary::getAllVocabulariesIdsArrByTitle();
        foreach ($vocabularies_ids_arr as $vocabulary_id) {
            $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);

            echo \Cebera\BT::beginTr();
            echo \Cebera\BT::td_plain(\Cebera\BT::a(\Guk\Pages\Terms\ControllerTerms::vocabularyUrl($vocabulary_obj->getId()), $vocabulary_obj->getTitle()));
            echo \Cebera\BT::td(date('d.m.Y', $vocabulary_obj->getCreatedAtTs()));
            echo \Cebera\BT::endTr();
        }

        echo \Cebera\BT::endTable();

        // MODALS

        echo \Cebera\BT::beginModal(self::ADD_VOCABULARY_MODAL_ID, 'Создание словаря');
        echo \Cebera\BT::beginForm(\Guk\Pages\Terms\ControllerTerms::vocabulariesAction(1), \Guk\Pages\Terms\ControllerTerms::ADD_VOCABULARY_OPERATION_CODE);

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