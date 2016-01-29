<?php

namespace Guk\GukPages\Templates;


use Guk\Pages\Forms\FormsController;

class FormTemplate
{
    const MODAL_ID_EDIT_CELL = 'MODAL_ID_EDIT_CELL';
    const FIELD_NAME_ROW_ID = 'FIELD_NAME_ROW_ID';
    const FIELD_NAME_COL_ID = 'FIELD_NAME_COL_ID';
    const FIELD_NAME_CELL_VALUE = 'FIELD_NAME_CELL_VALUE';

    static public function render($form_id){

        $form_obj = \Guk\FinForm::factory($form_id);

        echo \Cebera\BT::pageHeader_plain(\Cebera\BT::a(FormsController::formsAction(1), 'Формы') . ' / ' .  $form_obj->getComment());

        echo \Guk\Pages\Forms\FormTabsTemplate::render($form_id);

        if ($form_obj->isCurrent()) {
            echo '<div class="alert alert-warning" role="alert">Для текущей формы изменение полей запрещено.</div>';
            return;
        }

        $col_ids_arr = $form_obj->getColIdsArrByWeight();
        $row_ids_arr = $form_obj->getRowIdsArrByWeight();

        $max_row_weight = 0;
        $max_col_weight = 0;

        foreach ($row_ids_arr as $row_id) {
            $row_obj = \Guk\FinFormRow::factory($row_id);

            if ($row_obj->getWeight() > $max_row_weight) {
                $max_row_weight = $row_obj->getWeight();
            }
        }

        foreach ($col_ids_arr as $col_id) {
            $col_obj = \Guk\FinFormCol::factory($col_id);

            if ($col_obj->getWeight() > $max_col_weight) {
                $max_col_weight = $col_obj->getWeight();
            }
        }

        echo '<div>';
            echo \Cebera\BT::operationButton(
                FormsController::formAction(1, $form_obj->getId()),
                \Guk\GukPages\ControllerForms::OPERATION_CODE_ADD_ROW,
                'Добавить строку',
                array('weight' => $max_row_weight + 1)
            );

            echo '<form style="display: inline;" method="post" action="' . FormsController::formAction(1, $form_obj->getId()) . '">';
            echo '<input type="hidden" name="a" value="add_col"/>';
            echo '<input type="hidden" name="weight" value="' . ($max_col_weight + 1) . '"/>';
            echo '<input type="submit" class="btn btn-default" value="Добавить колонку"/>';
            echo '</form>';

        echo '</div>';

        echo \Cebera\BT::delimiter();

        echo \Cebera\BT::beginTable('table-bordered');

            echo '<thead><tr>';
            echo '<th>-</th>';

            foreach ($col_ids_arr as $col_id) {
                $col_obj = \Guk\FinFormCol::factory($col_id);

                echo '<th>';
                echo '<div><a href="' . \Guk\GukPages\ControllerForms::getFinFormColUrl($col_obj->getId()) . '">' . \Guk\Helpers::replaceEmptyString($col_obj->getTitle()) . '</a></div>';

                if ($col_obj->getIsEditableByVuz()) {
                    echo '<div>для заполнения ВУЗом</div>';
                }

                if ($col_obj->getVocabularyId()) {
                    $vocabulary_obj = \Guk\Vocabulary::factory($col_obj->getVocabularyId());
                    echo '<div>' . $vocabulary_obj->getTitle() . '</div>';
                }

                echo '</th>';
            }

            echo '<th>Лимит (тыс. руб.)</th>';
            echo '</tr></thead>';

            foreach ($row_ids_arr as $row_id) {
                $row_obj = \Guk\FinFormRow::factory($row_id);

                echo \Cebera\BT::beginTr();
                echo '<td><b><a href="' . FormsController::finFormRowAction(1, $row_obj->getId()) . '">' . \Guk\Helpers::replaceEmptyString($row_obj->getWeight()) . '</a></b></td>';

                foreach ($col_ids_arr as $col_id) {
                    $col_obj = \Guk\FinFormCol::factory($col_id);

                    if ($col_obj->getIsEditableByVuz()) {
                        echo '<td style="background-color: #eee;"></td>';
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

                            $cell_content_class = '';
                            if (trim($cell_value) == ''){ // trim на случай только пробелов в названии
                                $cell_content_class = ' glyphicon glyphicon-pencil ';
                            }

                            // используем pre чтобы не переписывать переносы строк в контенте
                            echo '<div class="' . $cell_content_class . '" style="cursor: pointer; border-bottom: 1px dashed gray;" data-rowid="' . $row_id . '" data-colid="' . $col_id . '" href="#" onclick="openCellEditModal($(this));">' . \Cebera\BT::sanitizeTagContent($cell_value) . '</div>';

                            echo '</td>';
                        }
                    }

                }

                $limit_str = number_format ( floatval($row_obj->getLimit()), 0 , "." , " " );
                echo '<td style="text-align: right; white-space:nowrap;">' . $limit_str . '</td>';
                echo \Cebera\BT::endTr();
            }

        echo \Cebera\BT::endTable();

        echo \Cebera\BT::beginModalForm(self::MODAL_ID_EDIT_CELL, 'Редактирование ячейки', FormsController::formAction(1, $form_id), FormsController::OPERATION_CODE_EDIT_CELL);
        echo '<input type="hidden" name="' . self::FIELD_NAME_ROW_ID. '" id="' . self::FIELD_NAME_ROW_ID. '">';
        echo '<input type="hidden" name="' . self::FIELD_NAME_COL_ID. '" id="' . self::FIELD_NAME_COL_ID. '">';
        echo \Cebera\BT::formGroup('Значение', '<textarea class="form-control" name="' . self::FIELD_NAME_CELL_VALUE. '" id="' . self::FIELD_NAME_CELL_VALUE. '"></textarea>');
        echo \Cebera\BT::endModalForm();

        ?>

        <script>
            function openCellEditModal(target_jquery_element){
                $("#<?= self::FIELD_NAME_ROW_ID ?>").val(target_jquery_element.data("rowid"));
                $("#<?= self::FIELD_NAME_COL_ID ?>").val(target_jquery_element.data("colid"));
                var value = target_jquery_element.html();
                var regex = /<br\s*[\/]?>/gi;
                value = value.replace(regex, "\n");
                $("#<?= self::FIELD_NAME_CELL_VALUE ?>").val(value);
                $("#<?= self::MODAL_ID_EDIT_CELL ?>").modal();
            }
        </script>

        <?php

    }
}