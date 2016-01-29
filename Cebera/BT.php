<?php

namespace Cebera;

class BT
{
    static public function delimiter(){
        return '<div>&nbsp;</div>';
    }

    static public function toolbar_plain($html){
        ob_start();

        echo self::div_plain($html);
        echo self::delimiter();

        return ob_get_clean();
    }

    static public function formCheckbox($field_name, $checked){
        ob_start();

        echo '<div class="checkbox">';
        echo '<label>';

        $checked_str = '';
        if ($checked){
            $checked_str = ' checked ';
        }

        echo '<input name="' . $field_name . '" type="checkbox" ' . $checked_str. ' >';
        echo '</label>';
        echo '</div>';

        return ob_get_clean();
    }

    static public function formInput($field_name, $field_value = '', $readonly = false){
        ob_start();

        $readonly_str = '';

        if ($readonly){
            $readonly_str = 'readonly';
        }

        echo '<input class="form-control" name="' . self::sanitizeAttrValue($field_name) . '" id="' . self::sanitizeAttrValue($field_name) . '" value="' . self::sanitizeAttrValue($field_value) . '" ' . $readonly_str . '/>';

        return ob_get_clean();
    }

    static public function hiddenInput($field_name, $field_value = ''){
        ob_start();

        echo '<input type="hidden" name="' . self::sanitizeAttrValue($field_name) . '" id="' . self::sanitizeAttrValue($field_name) . '" value="' . self::sanitizeAttrValue($field_value) . '"/>';

        return ob_get_clean();
    }

    static public function operationButton($form_action_url, $operation_code, $title, $data_arr = array()){
        ob_start();

        echo '<form style="display: inline;" method="post" action="' . self::sanitizeUrl($form_action_url) . '">';
        echo '<input type="hidden" name="operation_code" value="' . self::sanitizeAttrValue($operation_code) . '"/>';

        foreach ($data_arr as $key => $value){
            echo '<input type="hidden" name="' . self::sanitizeAttrValue($key) . '" value="' . self::sanitizeAttrValue($value) . '"/>';
        }

        echo '<input type="submit" class="btn btn-default" value="' . self::sanitizeAttrValue($title) . '"/>';
        echo '</form>';

        return ob_get_clean();
    }

    static public function getPostValue($field_name){
        if (isset($_POST[$field_name])){
            return $_POST[$field_name];
        }

        return '';
    }

    static public function matchOperation($operation_code, callable $callback_arr){
        if (isset($_POST['operation_code'])){
            if ($_POST['operation_code'] == $operation_code){
                call_user_func($callback_arr);
            }
        }
    }

    static public function modalToggleButton($modal_id, $title){
        return '<button class="btn btn-default" data-toggle="modal" data-target="#' . $modal_id . '">' . $title . '</button>';
    }

    static public function modalToggleLink($modal_id, $title, $data_attrs_arr = array()){
        $data_attrs_str = '';

        foreach ($data_attrs_arr as $attr_name => $attr_value){
            $data_attrs_str .= ' ' . $attr_name . '="' . $attr_value . '" '; // TODO: sanitize
        }

        return '<button ' . $data_attrs_str . ' class="btn btn-link" data-toggle="modal" data-target="#' . $modal_id . '">' . $title . '</button>';
    }

    static public function sanitizeTagContent($value){
        $value = htmlspecialchars($value);
        $value = preg_replace('@\R@mu', '<br>', $value);
        return $value;
    }

    static public function select($name, $values_arr, $current_id){
        ob_start();

        echo '<select class="form-control" name="' . $name . '">';
        echo '<option value=""></option>';

        foreach ($values_arr as $id => $title){
            $selected = '';
            if ($id == $current_id){
                $selected = ' selected ';
            }

            echo '<option value="' . $id . '" ' . $selected . ' >' . $title . '</option>';
        }

        echo '</select>';

        return ob_get_clean();
    }

    static public function sanitizeUrl($url){
        //return filter_var(FILTER_SANITIZE_URL, $url);
        return $url; // TODO: sanitize
    }

    static public function sanitizeAttrValue($value){
        return htmlspecialchars($value);
    }

    static public function th($val, $classes_str = ''){
        return '<th class="' . $classes_str . '">' . self::sanitizeTagContent($val) . '</th>';
    }

    static public function td($val, $classes_str = ''){
        return self::td_plain(self::sanitizeTagContent($val), $classes_str);
    }

    static public function td_plain($val, $classes_str = ''){
        return '<td class="' . $classes_str . '">' . $val . '</td>';
    }

    static public function beginTd(){
        return '<td>';
    }

    static public function endTd(){
        return '</td>';
    }

    static public function tr_plain($val){
        return self::beginTr() . $val . self::endTr();
    }

    static public function a($url, $text){
        return '<a href="' . self::sanitizeUrl($url) . '">' . self::sanitizeTagContent($text) . '</a>';
    }

    static public function beginTable($classes_str = ''){
        return '<table class="table ' . self::sanitizeAttrValue($classes_str) . ' ">';
    }

    static public function breadcrumbs($arr){
        ob_start();

        echo '<ol class="breadcrumb">';

        foreach ($arr as $url => $title){
            if ($url){
                echo '<li>' . self::a($url, $title) . '</li>';
            } else {
                echo '<li class="active">' . $title . '</li>';
            }
        }

        echo '</ol>';

        return ob_get_clean();
    }

    static public function h1_plain($value){
        return '<h1>' . $value . '</h1>';
    }

    static public function h2_plain($value){
        return '<h2>' . $value . '</h2>';
    }

    static public function pageHeader_plain($value){
        return '<div class="page-header"><h2>' . $value . '</h2></div>';
    }

    static public function div_plain($value){
        return '<div>' . $value . '</div>';
    }

    static public function beginTr($classes = ''){
        return '<tr class="' . self::sanitizeAttrValue($classes) . '">';
    }

    static public function endTable(){
        return '</table>';
    }

    static public function endTr(){
        return '</tr>';
    }

    static public function beginForm($action_url, $operation_code){
        ob_start();

        ?>
                    <form class="form-horizontal" method="post" action="<?= $action_url ?>">
                        <input type="hidden" name="operation_code" value="<?= $operation_code ?>">

        <?php

        return ob_get_clean();
    }

    static public function beginFormSimple($action_url, $operation_code){
        ob_start();

        ?>
        <form method="post" action="<?= $action_url ?>">
        <input type="hidden" name="operation_code" value="<?= $operation_code ?>">

        <?php

        return ob_get_clean();
    }

    static public function beginModalForm($modal_id, $modal_title, $action_url, $operation_code){
        ob_start();

        echo \Cebera\BT::beginModal($modal_id, $modal_title);
        echo \Cebera\BT::beginForm($action_url, $operation_code);
        echo \Cebera\BT::beginModalBody();

        return ob_get_clean();
    }


    static public function beginModal($modal_id, $modal_title){
        ob_start();

        ?>
        <div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $modal_title ?></h4>
                    </div>
        <?php

        return ob_get_clean();
    }

    static public function beginModalBody(){
        return '<div class="modal-body">';
    }

    static public function endModalBody(){
        return '</div>';
    }

    static public function endForm(){
        return '</form>';
    }

    static public function endModalForm(){
        ob_start();

        echo \Cebera\BT::endModalBody();
        echo \Cebera\BT::modalFooterCloseAndSubmit();
        echo \Cebera\BT::endForm();
        echo \Cebera\BT::endModal();

        return ob_get_clean();
    }

    static public function endModal(){
        ob_start();

        ?>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    static public function formSubmit(){
        ob_start();

        ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="form-control btn btn-primary">Сохранить</button>
                </div>
            </div>
        <?php

        return ob_get_clean();
    }

    static public function formGroup($title, $contents){
        ob_start();

        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?= $title ?></label>
            <div class="col-sm-10">
                <?= $contents ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    static public function modalFooterCloseAndSubmit(){
        ob_start();

        ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        <?php

         return ob_get_clean();
   }
}