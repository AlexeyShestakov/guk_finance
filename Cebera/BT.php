<?php

namespace Cebera;

class BT
{
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

    static public function sanitizeTagContent($value){
        return htmlspecialchars($value);
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

    static public function th($val){
        return '<th>' . self::sanitizeTagContent($val) . '</th>';
    }

    static public function td($val){
        return self::td_plain(self::sanitizeTagContent($val));
    }

    static public function td_plain($val){
        return '<td>' . $val . '</td>';
    }

    static public function tr_plain($val){
        return self::beginTr() . $val . self::endTr();
    }

    static public function a($url, $text){
        return '<a href="' . self::sanitizeUrl($url) . '">' . self::sanitizeTagContent($text) . '</a>';
    }

    static public function beginTable(){
        return '<table class="table">';
    }

    static public function h1_plain($value){
        return '<h1>' . $value . '</h1>';
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