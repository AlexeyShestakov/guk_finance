<?php

namespace Cebera\Tree;

/**
 * Interface InterfaceTree
 * @package Sportbox\Model
 * Класс должен иметь метод getAllParentsIdsArr, который возвращает идентификаторы всех его предков в обратном порядке,
 * т.е. первым идет непосредственный предок, а последник - корневой
 */
interface InterfaceTree {
    public function getAllParentsIdsArr();
}