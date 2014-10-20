<?php
namespace Flex\Data\ModelGenerator;

/**
 * Class Generator
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Generator {

    /**
     * @var string
     */
    private $root;

    /**
     * @var EntityCollection
     */
    private $entities;

    /**
     * @param string $root
     */
    public function setRoot($root) {
        $this->root = $root;
    }

    /**
     * @return string
     */
    public function getRoot() {
        return $this->root;
    }

    /**
     * @param EntityCollection $entities
     */
    public function setEntities($entities) {
        $this->entities = $entities;
    }

    /**
     * @return EntityCollection
     */
    public function getEntities() {
        return $this->entities;
    }
}