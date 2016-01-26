<?php

namespace Guk\GukPages\Templates;


class FormPageTemplate
{
    static public function render($form_id){

        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::h1_plain(\Cebera\BT::a(\Guk\GukPages\ControllerForms::getFinFormsPageUrl(), 'Формы') . ' / ' . $form_obj->getComment());

        echo \Cebera\Render\Render::callLocaltemplate('form_tabs.tpl.php', array('form_id' => $form_id));
        echo \Cebera\BT::div_plain('&nbsp;');

        if ($form_obj->isCurrent()) {
            echo '<div class="alert alert-warning" role="alert">Для текущей формы изменение полей запрещено.</div>';
            return;
        }

        $col_ids_arr = $form_obj->getColIdsArrByWeight();
        $row_ids_arr = $form_obj->getRowIdsArrByWeight();

        echo \Cebera\BT::beginTable('table-bordered table-condensed');

            echo '<thead><tr>';
            echo '<th>-</th>';

            foreach ($col_ids_arr as $col_id) {
                $col_obj = \Guk\FinFormCol::factory($col_id);

                echo '<th><a href="' . \Guk\GukPages\ControllerForms::getFinFormColUrl($col_obj->getId()) . '">' . \Guk\Helpers::replaceEmptyString($col_obj->getTitle()) . '</a></th>';
            }

            echo '<th>Лимит (тыс. руб.)</th>';
            echo '</tr></thead>';

            $max_row_weight = 0;
            $max_col_weight = 0;

            foreach ($row_ids_arr as $row_id) {
                $row_obj = \Guk\FinFormRow::factory($row_id);

                if ($row_obj->getWeight() > $max_row_weight) {
                    $max_row_weight = $row_obj->getWeight();
                }

                echo '<tr>';
                echo '<td><a href="' . \Guk\GukPages\ControllerForms::getFinFormRowUrl($row_obj->getId()) . '">' . \Guk\Helpers::replaceEmptyString($row_obj->getWeight()) . '</a></td>';

                foreach ($col_ids_arr as $col_id) {
                    $col_obj = \Guk\FinFormCol::factory($col_id);

                    if ($col_obj->getWeight() > $max_col_weight) {
                        $max_col_weight = $col_obj->getWeight();
                    }

                    if ($col_obj->getIsEditableByVuz()) {
                        echo '<td>для вуза</td>';
                    } else {
                        if ($col_obj->getVocabularyId()){
                            echo '<td style="background-color: #eee;">';

                            $row_to_term_obj = \Guk\FormRowToTerm::getObjForFormRowAndVocabulary($row_id, $col_obj->getVocabularyId());
                            if ($row_to_term_obj){
                                $term_id = $row_to_term_obj->getTermId();
                                $term_obj = \Guk\Term::factory($term_id);

                                echo $term_obj->getTitle();
                            }

                            echo '</td>';

                        } else {
                            $cell_value = '';

                            $cell_obj = \Guk\FinFormCell::getObjForRowAndCol($row_obj->getId(), $col_obj->getId());
                            if ($cell_obj) {
                                $cell_value = $cell_obj->getValue();
                            }

                            echo '<td>';
                            echo '<form method="post" action="' . \Guk\GukPages\ControllerForms::formUrl($form_obj->getId()) . '">';
                            echo '<input type="hidden" name="a" value="set_value"/>';
                            echo '<input type="hidden" name="row_id" value="' . $row_obj->getId() . '"/>';
                            echo '<input type="hidden" name="col_id" value="' . $col_obj->getId() . '"/>';
                            echo '<input name="value" style="width: 100%; border: 0px; border-bottom: 1px solid #222;" value="' . $cell_value . '"/></form>';
                            echo '</td>';
                        }
                    }

                }

                $limit_str = number_format ( floatval($row_obj->getLimit()), 0 , "." , " " );
                echo '<td style="text-align: right; white-space:nowrap;">' . $limit_str . '</td>';
                echo '</tr>';
            }

        echo \Cebera\BT::endTable();

            ?>

        <div>

            <?php

            echo '<form style="display: inline;" method="post" action="' . \Guk\GukPages\ControllerForms::formUrl($form_obj->getId()) . '">';
            echo '<input type="hidden" name="a" value="add_row"/>';
            echo '<input type="hidden" name="weight" value="' . ($max_row_weight + 1) . '"/>';
            echo '<input type="submit" class="btn btn-default" value="Добавить строку"/>';
            echo '</form>';

            echo '<form style="display: inline;" method="post" action="' . \Guk\GukPages\ControllerForms::formUrl($form_obj->getId()) . '">';
            echo '<input type="hidden" name="a" value="add_col"/>';
            echo '<input type="hidden" name="weight" value="' . ($max_col_weight + 1) . '"/>';
            echo '<input type="submit" class="btn btn-default" value="Добавить колонку"/>';
            echo '</form>';
            ?>
        </div>
        <?php
    }
}