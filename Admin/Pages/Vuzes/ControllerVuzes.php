<?php

namespace Admin\Pages\Vuzes;

use Cebera\BT;

class ControllerVuzes
{
    static public function vuzesAction($mode){
        $self_url = '/admin/vuzes';
        if ($mode == 1) return $self_url;
        if ($mode == 2) return array(__METHOD__, $self_url);

        //

        BT::matchOperation(VuzesTemplate::OPERATION_ADD_VUZ, function() {
            $new_vuz_obj = new \Guk\Vuz();
            $new_vuz_obj->setTitle(BT::getPostValue(VuzesTemplate::FIELD_VUZ_NAME));
            $new_vuz_obj->save();

            \OLOG\Helpers::redirect(self::vuzesAction(1));
        });

        //

        ob_start();
        VuzesTemplate::render();
        $content = ob_get_clean();

        \Admin\Pages\AdminLayoutTemplate::render($content);
    }

}