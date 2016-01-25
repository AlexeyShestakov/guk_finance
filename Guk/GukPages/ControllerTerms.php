<?php

namespace Guk\GukPages;

class ControllerTerms
{
    const ADD_VOCABULARY_OPERATION_CODE = 'add_vocabulary';
    const ADD_TERM_OPERATION_CODE = 'add_term';

    static public function vocabulariesUrl(){
        return '/guk/vocabularies';
    }

    public function vocabulariesAction(){
        \Cebera\BT::matchOperation(
            \Guk\GukPages\ControllerTerms::ADD_VOCABULARY_OPERATION_CODE,
            function() {\Guk\GukPages\ControllerTerms::addVocabularyOperation();}
        );

        ob_start();
        \Guk\GukPages\Templates\VocabulariesTemplate::render();
        $content = ob_get_clean();

        \Guk\GukPages\Templates\GukLayoutTemplate::render($content);
    }

    static public function vocabularyUrl($id){
        return '/guk/vocabulary/' . $id;
    }

    public function vocabularyAction($vocabulary_id){
        \Cebera\BT::matchOperation(
            \Guk\GukPages\ControllerTerms::ADD_TERM_OPERATION_CODE,
            function() use ($vocabulary_id) {\Guk\GukPages\ControllerTerms::addTermOperation($vocabulary_id);}
        );

        ob_start();
        \Guk\GukPages\Templates\VocabularyTemplate::render($vocabulary_id);
        $content = ob_get_clean();

        \Guk\GukPages\Templates\GukLayoutTemplate::render($content);
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
}