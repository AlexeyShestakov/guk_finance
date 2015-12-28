<?php

namespace Cebera\Logger;


class ControllerLogger
{

    public function object_logAction()
    {
        $logger_objs_id = urldecode(\Cebera\Helpers::url_arg(3));

        // Проверка прав доступа
        $model_class_name = $this->getCurrentModelClassName($logger_objs_id);
        \Cebera\Helpers::exit403If(!\Cebera\Logger\Helper::currentUserHasRightsToViewLog($model_class_name));

        $logger_objs_arr = \Cebera\DB\DBWrapper::readObjects(\Cebera\Constants::DB_NAME_PARKFACE,
            "SELECT id, http_auth_user_name, user_id, action, ts, ip FROM admin_log WHERE entity_id = ? ORDER BY ts DESC",
            array($logger_objs_id)
        );

        $html = \Cebera\Render\Render::template2('Cebera/Logger/templates/object_log.tpl.php', array(
                'logger_objs_arr' => $logger_objs_arr
            )
        );

        echo \Cebera\Render::template2('Cebera/Admin/templates/guk_layout.tpl.php', array(
                'title' => 'История "' . $logger_objs_id . '"',
                'content' => $html
             )
        );
    }

    public function recordAction()
    {
        $record_id = \Cebera\Helpers::url_arg(3);

        $html = '';

        $html .= self::renderRecordHead($record_id);
        $html .= self::delta($record_id);
        $html .= self::renderObjectFields($record_id);

        $record_obj = \Cebera\DB\DBWrapper::readObject(\Cebera\Constants::DB_NAME_PARKFACE,
            "SELECT user_id, http_auth_user_name, ts, ip, action, entity_id, object FROM admin_log WHERE id = ?",
            array($record_id)
        );

        $model_class_name = $this->getCurrentModelClassName($record_obj->entity_id);
        \Cebera\Helpers::exit403If(!\Cebera\Logger\Helper::currentUserHasRightsToViewLog($model_class_name));

        if (!$record_obj) {
            return 'missing record';
        }

        echo \Cebera\Render::template2('Cebera/Admin/templates/guk_layout.tpl.php', array(
                'title' => 'Запись ' . $record_obj->ts,
                'content' => $html,
                'breadcrumbs_arr' => array('История' => '/admin2/logger/object_log/' . urlencode($record_obj->entity_id))
            )
        );

    }

    /**
     * @param $entity_id
     * @return string
     * @throws \Exception
     */
    protected function getCurrentModelClassName($entity_id)
    {
        $records_chunk_arr = explode('.', $entity_id);

        $model_class_name = array_shift($records_chunk_arr);
        $model_class_name = urldecode($model_class_name);

        if (!class_exists($model_class_name)) {
            throw new \Exception('Класс модели не найден ' . $entity_id);
        }

        return $model_class_name;
    }

    static public function renderRecordHead($record_id)
    {
        $record_obj = \Cebera\DB\DBWrapper::readObject(\Cebera\Constants::DB_NAME_PARKFACE,
            "SELECT user_id, http_auth_user_name, ts, ip, action, entity_id, object FROM admin_log WHERE id = ?",
            array($record_id)
        );

        
        return '
<dl class="dl-horizontal jumbotron" style="margin-top:20px;padding: 10px;">
	<dt style="padding: 5px 0;">Администратор</dt>
	<dd style="padding: 5px 0;">' . $record_obj->http_auth_user_name . '</dd>
	<dt style="padding: 5px 0;">Пользователь</dt>
	<dd style="padding: 5px 0;">' . $record_obj->user_id . '</dd>
	<dt style="padding: 5px 0;">Время изменения</dt>
    <dd style="padding: 5px 0;">' . $record_obj->ts . '</dd>
    <dt style="padding: 5px 0;">IP адрес</dt>
    <dd style="padding: 5px 0;">' . $record_obj->ip . '</dd>
    <dt style="padding: 5px 0;">Тип изменения</dt>
    <dd style="padding: 5px 0;">' . $record_obj->action . '</dd>
    <dt style="padding: 5px 0;">Идентификатор</dt>
    <dd style="padding: 5px 0;">' . $record_obj->entity_id . '</dd>
</dl>
   ';
    }

    static public function renderObjectFields($record_id)
    {
        $html = '<h3>Все поля объекта</h3>';

        $logger_objs_arr = \Cebera\DB\DBWrapper::readObject(\Cebera\Constants::DB_NAME_PARKFACE,
            "SELECT user_id, ts, ip, action, entity_id, object FROM admin_log WHERE id = ?",
            array($record_id)
        );

        $record_objs = unserialize(stripslashes($logger_objs_arr->object));

        $value_as_list = self::convertValueToList($record_objs);
        ksort($value_as_list); // сортируем для красоты

        //$html .= '<table class="table">';
        $last_path = '';

        foreach ($value_as_list as $path => $value) {
            $path_to_display = $path;

            if (self::getPathWithoutLastElement($last_path) == self::getPathWithoutLastElement($path)) {
                $elems = explode('.', $path);
                $last_elem = array_pop($elems);
                if (count($elems)) {
                    $path_to_display = '<span style="color: #999">' . implode('.', $elems) . '</span>.' . $last_elem;
                }
            }

            /*
            $html .= '<tr>';
            $html .= '<td>' . $path_to_display . '</td>';
            $html .= '<td><pre style="white-space: pre-wrap;">' . $value . '</pre></td>';
            $html .= '</tr>';
            */

            if (strlen($value) > 100){
                $html .= '<div style="padding: 5px 0px; border-bottom: 1px solid #ddd;">';

                $html .= '<div><b>' . $path_to_display . '</b>: </div>';
                $html .= '<div><pre style="white-space: pre-wrap;">' . $value . '</pre></div>';
                $html .= '</div>';
            } else {
                $html .= '<div style="padding: 5px 0px; border-bottom: 1px solid #ddd;">';

                $html .= '<span style="padding-right: 50px;"><b>' . $path_to_display . ': </b></span>';
                $html .= $value;
                $html .= '</div>';
            }


            $last_path = $path;
        }
        //$html .= '</table>';

        return $html;
    }

    static public function getPathWithoutLastElement($path)
    {
        $elems = explode('.', $path);
        array_pop($elems);
        return implode('.', $elems);
    }

    static public function delta($current_record_id)
    {
        $html = '';

        $current_record_obj = \Cebera\DB\DBWrapper::readObject(\Cebera\Constants::DB_NAME_PARKFACE,
            "SELECT id, http_auth_user_name, user_id, ts, ip, action, entity_id, object FROM admin_log WHERE id = ?",
            array($current_record_id)
        );

        if (!$current_record_obj) {
            return 'не найден объект текущей записи';
        }

        // находим предыдущую запись лога для этого объекта

        $prev_record_obj = \Cebera\DB\DBWrapper::readObject(\Cebera\Constants::DB_NAME_PARKFACE,
            "SELECT id, http_auth_user_name, user_id, ts, ip, action, entity_id, object FROM admin_log WHERE id < ? AND entity_id = ? ORDER BY id DESC LIMIT 1",
            array($current_record_id, $current_record_obj->entity_id)
        );

        if (!$prev_record_obj) {
            return '<div>Предыдущая запись истории для этого объекта не найдена.</div>';
        }

        // определение дельты

        $html .= '<h3>Изменения относительно <a href="#/logger/show/' . $prev_record_obj->id . '">предыдущей версии</a></h3>';

        $current_obj = unserialize(stripslashes($current_record_obj->object));
        $prev_obj = unserialize(stripslashes($prev_record_obj->object));

        $current_record_as_list = self::convertValueToList($current_obj);
        ksort($current_record_as_list); // сортируем для красоты
        $prev_record_as_list = self::convertValueToList($prev_obj);
        ksort($prev_record_as_list); // сортируем для красоты

        $html .= '<table class="table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Поле</th>';
        $html .= '<th>Старое значение</th>';
        $html .= '<th>Новое значение</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        $added_rows = array_diff_key($current_record_as_list, $prev_record_as_list);

        foreach ($added_rows as $k => $v) {
            $html .= '<tr>';
            $html .= '<td><b>' . $k . '</b></td>';
            $html .= '<td style="background-color: #eee;"></td>';
            $html .= '<td>' . self::renderDeltaValue($v) . '</td>';
            $html .= '</tr>';
        }

        $deleted_rows = array_diff_key($prev_record_as_list, $current_record_as_list);

        foreach ($deleted_rows as $k => $v) {
            $html .= '<tr>';
            $html .= '<td><b>' . $k . '</b></td>';
            $html .= '<td>' . self::renderDeltaValue($v) . '</td>';
            $html .= '<td style="background-color: #eee;"></td>';
            $html .= '</tr>';
        }

        foreach ($current_record_as_list as $k => $current_v) {
            if (array_key_exists($k, $prev_record_as_list)) {
                $prev_v = $prev_record_as_list[$k];
                if ($current_v != $prev_v) {
                    $html .= '<tr>';
                    $html .= '<td><b>' . $k . '</b></td>';
                    $html .= '<td>' . self::renderDeltaValue($prev_v) . '</td>';
                    $html .= '<td>' . self::renderDeltaValue($current_v) . '</td>';
                    $html .= '</tr>';
                }
            }
        }

        $html .= '</table>';

        $html .= '<div>Для длинных значений полный текст здесь не приведен, его можно увидеть в полях объекта ниже.</div>';

        return $html;
    }

    static public function renderDeltaValue($v)
    {
        $limit = 300;

        if (strlen($v) < $limit) {
            return $v;
        }

        return mb_substr($v, 0, $limit) . '...';
    }

    static public function convertValueToList($value_value, $value_path = '')
    {
        if (is_null($value_value)) {
            return array($value_path => '#NULL#');
        }

        if (is_scalar($value_value)) {
            return array($value_path => htmlentities($value_value));
        }

        $value_as_array = null;
        $output_array = array();

        if (is_array($value_value)) {
            $value_as_array = $value_value;
        }

        if (is_object($value_value)) {
            $value_as_array = array();

            foreach ($value_value as $property_name => $property_value) {
                $value_as_array[$property_name] = $property_value;
            }

            $reflect = new \ReflectionClass($value_value);
            $properties = $reflect->getProperties();

            foreach ($properties as $prop_obj) {
                // не показываем статические свойства класса - они не относятся к конкретному объекту (например, это могут быть настройки круда для класса) и в журнале не нужны
                if ($prop_obj->isStatic()) {
                    continue;
                }

                $prop_obj->setAccessible(true);
                $name = $prop_obj->getName();
                $value = $prop_obj->getValue($value_value);
                $value_as_array[$name] = $value;
            }
        }

        if (!is_array($value_as_array)) {
            throw new \Exception('Не удалось привести значение к массиву');
        }

        foreach ($value_as_array as $key => $value) {
            $key_path = $key;
            if ($value_path != '') {
                $key_path = $value_path . '.' . $key;
            }

            $value_output = self::convertValueToList($value, $key_path);
            $output_array = array_merge($output_array, $value_output);
        }

        return $output_array;
    }


}
