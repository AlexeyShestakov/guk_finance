<?php

namespace Guk;

class FinFormHelper
{
    public function getCurrentFormId(){
        $current_form_id = \OLOG\DB\DBWrapper::readField(
            \AppConfig\Config::DB_NAME_GUK_FINANCE,
            'select id from fin_form where is_current = 1 limit 1'
            );

        return $current_form_id;
    }
}