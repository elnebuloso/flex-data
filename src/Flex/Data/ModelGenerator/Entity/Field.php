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
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $phpMethod;

    /**
     * @var string
     */
    private $phpType;

    /**
     * @var bool
     */
    private $phpTypeHinting;

    /**
     * @return self
     */
    public function __construct() {
        $this->phpType = 'mixed';
        $this->phpTypeHinting = false;
    }

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
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $phpMethod
     */
    public function setPhpMethod($phpMethod) {
        $this->phpMethod = $phpMethod;
    }

    /**
     * @return string
     */
    public function getPhpMethod() {
        return $this->phpMethod;
    }

    /**
     * @param string $phpType
     */
    public function setPhpType($phpType) {
        $this->phpType = $phpType;
    }

    /**
     * @return string
     */
    public function getPhpType() {
        return $this->phpType;
    }

    /**
     * @param bool $phpTypeHinting
     */
    public function setPhpTypeHinting($phpTypeHinting) {
        $this->phpTypeHinting = $phpTypeHinting;
    }

    /**
     * @return bool
     */
    public function getPhpTypeHinting() {
        return $this->phpTypeHinting;
    }
}