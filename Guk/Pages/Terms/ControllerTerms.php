<?php

namespace Guk\Pages\Terms;

class ControllerTerms
{
    const ADD_VOCABULARY_OPERATION_CODE = 'ADD_VOCABULARY_OPERATION_CODE';
    const DELETE_VOCABULARY_OPERATION_CODE = 'DELETE_VOCABULARY_OPERATION_CODE';
    const RENAME_VOCABULARY_OPERATION_CODE = 'RENAME_VOCABULARY_OPERATION_CODE';
    const ADD_TERM_OPERATION_CODE = 'ADD_TERM_OPERATION_CODE';

    static public function vocabulariesUrl(){
        return '/guk/vocabularies';
    }

    public function vocabulariesAction(){
        \Cebera\BT::matchOperation(
            \Guk\Pages\Terms\ControllerTerms::ADD_VOCABULARY_OPERATION_CODE,
            function() {\Guk\Pages\Terms\ControllerTerms::addVocabularyOperation();}
        );

        ob_start();
        \Guk\GukPages\Templates\VocabulariesTemplate::render();
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function vocabularyUrl($id){
        return '/guk/vocabulary/' . $id;
    }

    public function vocabularyAction($vocabulary_id){
        \Cebera\BT::matchOperation(
            \Guk\Pages\Terms\ControllerTerms::ADD_TERM_OPERATION_CODE,
            function() use ($vocabulary_id) {\Guk\Pages\Terms\ControllerTerms::addTermOperation($vocabulary_id);}
        );

        \Cebera\BT::matchOperation(
            \Guk\Pages\Terms\ControllerTerms::DELETE_VOCABULARY_OPERATION_CODE,
            function() use ($vocabulary_id) {\Guk\Pages\Terms\ControllerTerms::deleteVocabularyOperation($vocabulary_id);}
        );

        \Cebera\BT::matchOperation(
            \Guk\Pages\Terms\ControllerTerms::RENAME_VOCABULARY_OPERATION_CODE,
            function() use ($vocabulary_id) {\Guk\Pages\Terms\ControllerTerms::renameVocabularyOperation($vocabulary_id);}
        );

        ob_start();
        \Guk\Pages\Terms\VocabularyTemplate::render($vocabulary_id);
        $content = ob_get_clean();

        \Guk\Pages\GukLayoutTemplate::render($content);
    }

    static public function addVocabularyOperation(){
        $title = $_POST['title'];

        \OLOG\Helpers::assert(mb_strlen($title) > 2);

        $vocabulary_obj = new \Guk\Vocabulary();
        $vocabulary_obj->setTitle($title);
        $vocabulary_obj->save();

        \OLOG\Helpers::redirect(self::vocabulariesUrl());
    }

    static public function addTermOperation($vocabulary_id){
        $title = $_POST['title'];

        \OLOG\Helpers::assert(mb_strlen($title) > 1);

        $term_obj = new \Guk\Term();
        $term_obj->setTitle($title);
        $term_obj->setVocabularyId($vocabulary_id);
        $term_obj->save();

        \OLOG\Helpers::redirect(self::vocabularyUrl($vocabulary_id));
    }

    static public function renameVocabularyOperation($vocabulary_id){
        $title = \Cebera\BT::getPostValue(\Guk\Pages\Terms\VocabularyTemplate::FIELD_NAME_VOCABULARY_TITLE);

        \OLOG\Helpers::assert(mb_strlen($title) > 1);

        $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);
        $vocabulary_obj->setTitle($title);
        $vocabulary_obj->save();

        \OLOG\Helpers::redirect(self::vocabularyUrl($vocabulary_id));
    }

    static public function deleteVocabularyOperation($vocabulary_id){
        $vocabulary_obj = \Guk\Vocabulary::factory($vocabulary_id);
        $vocabulary_obj->delete();

        \OLOG\Helpers::redirect(self::vocabulariesUrl());
    }
}