<?php


namespace Cebera\KeyValue;

class Item implements
    \Cebera\Model\InterfaceLoad,
    \Cebera\Model\InterfaceSave,
    \Cebera\Model\InterfaceDelete,
    \Cebera\Model\InterfaceFactory
{
    use \Cebera\Util\ActiveRecord;
    use \Cebera\Model\ProtectProperties;
    use \Cebera\Tree\Item;
    use \Cebera\Model\FactoryTrait;

    const DB_TABLE_NAME = 'keyvalue_items';
    const DB_ID = \Cebera\Constants::DB_NAME_PARKFACE;

    protected $id = 0;
    protected $name = '';
    protected $value = '';
    protected $fullname = '';
    protected $description = '';

    public static $active_record_ignore_fields_arr = array('children_item_ids_arr');

    public function getId()
    {
        return $this->id;
    }

    public function load($id)
    {
        $is_loaded = \Cebera\Util\ActiveRecordHelper::loadModelObj($this, $id);

        if (!$is_loaded) {
            return false;
        }

        $this->loadChildrenIdsArr();

        return true;
    }

    public function save()
    {
        if (!$this->getId() && $this->getName() == '') {
            $this->setName("NEW_" . time());
        }
        $this->generateFullname();

        \Cebera\Util\ActiveRecordHelper::saveModelObj($this);

        self::afterUpdate($this->getId());
    }

    protected function generateFullname()
    {
        $fullname = '';

        $all_parents_ids_arr = $this->getAllParentsIdsArr();
        foreach ($all_parents_ids_arr as $obj_id) {
            $obj_obj = self::factory($obj_id);
            $fullname .= $obj_obj->getName() . '.';
        }

        $fullname .= $this->getName();

        $this->setFullname($fullname);
    }

    public function getAllParentsIdsArr($prev_parents_ids_arr = array())
    {
        if (!$this->getParentId()) {
            return $prev_parents_ids_arr;
        }

        $parent_obj = self::factory($this->getParentId());
        \Cebera\Helpers::assert($parent_obj);

        array_unshift($prev_parents_ids_arr, $this->getParentId());
        return $parent_obj->getAllParentsIdsArr($prev_parents_ids_arr);
    }

    public function delete()
    {

        // BEFORE DELETE CHECKS

        $childrens_arr = $this->getChildrenIdsArr();
        if (count($childrens_arr) > 0) {
            throw new \Exception("Trying to delete menu item with children");
        }

        // DELETE AND CLEANUP

        \Cebera\Util\ActiveRecordHelper::deleteModelObj($this);

        $this->resetTreeRootAndParentCache();
        $this->afterDelete();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    static public function afterUpdate($item_id)
    {
        $class_name = self::getMyGlobalizedClassName();
        \Cebera\Model\FactoryHelper::removeObjFromCacheById($class_name, $item_id);

        $key_value_item_obj = self::factory($item_id);
        \Cebera\Helpers::assert($key_value_item_obj);

        $parent_id = $key_value_item_obj->getParentId();
        if ($parent_id) {
            \Cebera\Model\FactoryHelper::removeObjFromCacheById($class_name, $parent_id);
        }
    }
}