<?php
namespace Flex\Data\ModelGenerator\Entity;

/**
 * Class Field
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Field {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $typeHinting = false;

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param boolean $typeHinting
     */
    public function setTypeHinting($typeHinting) {
        $this->typeHinting = $typeHinting;
    }

    /**
     * @return boolean
     */
    public function getTypeHinting() {
        return $this->typeHinting;
    }
}