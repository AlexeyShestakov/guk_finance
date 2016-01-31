<?php

namespace Vuz\Pages;

use Guk\Term;

class ControllerAjax
{
    static public function vocabularyTermsAction($mode, $vocabulary_id){
        $self_url = '/vuz/ajax/vocabulary/' . $vocabulary_id . '/terms';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        $term_ids_arr = \Guk\Term::getTermIdsArrForVocabularyByTitle($vocabulary_id);

        $output_json = array();

        foreach ($term_ids_arr as $term_id){
            $term_obj = \Guk\Term::factory($term_id);
            $output_json[] = array('id' => $term_id, 'title' => $term_obj->getTitle());
        }

        \OLOG\Helpers::doJsonResponse($output_json);
    }
}