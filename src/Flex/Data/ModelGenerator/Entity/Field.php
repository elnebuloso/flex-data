<?php
namespace Flex\Data\ModelGenerator\Entity;

use Exception;

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
    private $defaultValue;

    /**
     * @var string
     */
    private $phpName;

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
     * @throws Exception
     */
    public function setName($name) {
        $this->name = trim(strtolower($name));

        if(empty($this->name)) {
            throw new Exception('field name cannot be emtpy', 1000);
        }
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue) {
        $this->defaultValue = trim($defaultValue);
    }

    /**
     * @return string
     */
    public function getDefaultValue() {
        return $this->defaultValue;
    }

    /**
     * @param string $phpName
     */
    public function setPhpName($phpName) {
        $this->phpName = trim($phpName);
    }

    /**
     * @return string
     */
    public function getPhpName() {
        if(empty($this->phpName)) {
            return lcfirst(implode(null, array_map('ucfirst', explode('_', $this->getName()))));
        }

        return $this->phpName;
    }

    /**
     * @param string $phpType
     */
    public function setPhpType($phpType) {
        $this->phpType = trim($phpType);
    }

    /**
     * @return string
     */
    public function getPhpType() {
        if(empty($this->phpType)) {
            return 'mixed';
        }

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