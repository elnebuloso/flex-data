<?php
namespace Flex\Data;

/**
 * Class AbstractObjectCollection
 *
 * @package Flex\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class AbstractObjectCollection extends Collection {

    /**
     * @var array
     */
    private $additional = array();

    /**
     * @return array
     */
    public function getObjects() {
        return $this->getElements();
    }

    /**
     * @param array $objects
     */
    public function setObjects(array $objects) {
        $this->setElements($objects);
    }

    /**
     * @param AbstractObject $object
     * @param array $data
     */
    public function addObject(AbstractObject $object, array $data = null) {
        $this->addElement($object, $object->getId(), $data);
        $this->additional[$object->getId()] = $data;
    }

    /**
     * @param AbstractObject $object
     * @return mixed
     */
    public function getAdditional(AbstractObject $object) {
        return $this->additional[$object->getId()];
    }
}