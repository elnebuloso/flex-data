<?php
namespace Flex\Data\ModelGenerator;

use Exception;
use Flex\Data\ModelGenerator\Entity\FieldCollection;

/**
 * Class Entity
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Entity {

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $target;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $className;

    /**
     * @var FieldCollection
     */
    private $fields;

    /**
     * @return self
     */
    public function __construct() {
        $this->fields = new FieldCollection();
    }

    /**
     * @param string $namespace
     * @throws Exception
     */
    public function setNamespace($namespace) {
        $this->namespace = trim($namespace);

        if(empty($this->namespace)) {
            throw new Exception('entity namespace cannot be emtpy', 1000);
        }
    }

    /**
     * @return string
     */
    public function getNamespace() {
        return $this->namespace;
    }

    /**
     * @param string $target
     * @throws Exception
     */
    public function setTarget($target) {
        $this->target = realpath($target);

        if($this->target === false) {
            throw new Exception('entity has invalid path to model output: ' . $target, 1000);
        }
    }

    /**
     * @return string
     */
    public function getTarget() {
        return $this->target;
    }

    /**
     * @param string $name
     * @throws Exception
     */
    public function setName($name) {
        $this->name = trim(strtolower($name));

        if(empty($this->name)) {
            throw new Exception('entity name cannot be emtpy', 1000);
        }
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $className
     */
    public function setClassName($className) {
        $this->className = trim($className);
    }

    /**
     * @return string
     */
    public function getClassName() {
        if(empty($this->className)) {
            return implode('\\', array_map('ucfirst', explode('_', $this->getName())));
        }

        return $this->className;
    }

    /**
     * @return FieldCollection
     */
    public function getFields() {
        return $this->fields;
    }
}