<?php
namespace Flex\Data;

/**
 * Class AbstractObjectCollection
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class AbstractObjectCollection extends Collection {

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
     */
    public function addObject(AbstractObject $object) {
        $this->addElement($object);
    }
}