<?php

namespace Admin\Pages\Vuzes;

use Cebera\BT;

class VuzesTemplate
{
    const MODAL_ADD_VUZ = 'MODAL_ADD_VUZ';
    const OPERATION_ADD_VUZ = 'OPERATION_ADD_VUZ';
    const FIELD_VUZ_NAME = 'FIELD_VUZ_NAME';

    static public function render(){
        echo BT::pageHeader_plain('ВУЗы');

        echo BT::toolbar_plain(
            BT::modalToggleButton(self::MODAL_ADD_VUZ, 'Добавить ВУЗ')
        );

        $vuz_ids_arr = \Guk\Vuz::getAllIdsArrByIdDesc();

        echo BT::beginTable();

        foreach ($vuz_ids_arr as $vuz_id){
            $vuz_obj = \Guk\Vuz::factory($vuz_id);

            echo BT::beginTr();

            echo BT::td_plain($vuz_obj->getId());
            echo BT::td_plain($vuz_obj->getTitle());

            echo BT::endTr();
        }

        echo BT::endTable();

        //

        echo BT::beginModalForm(self::MODAL_ADD_VUZ, 'Добавить ВУЗ', ControllerVuzes::vuzesAction(1), self::OPERATION_ADD_VUZ);
        echo BT::formGroup(
            'Название',
            BT::formInput(self::FIELD_VUZ_NAME)
        );
        echo BT::endModalForm();
    }
}