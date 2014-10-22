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
    private $class;

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
            throw new Exception('namespace cannot be emtpy', 1000);
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
            throw new Exception('invalid path to model output: ' . $target, 1000);
        }
    }

    /**
     * @return string
     */
    public function getTarget() {
        return $this->target;
    }

    /**
     * @param string $class
     * @throws Exception
     */
    public function setClass($class) {
        $this->class = trim($class);

        if(empty($this->class)) {
            throw new Exception('class cannot be emtpy', 1000);
        }
    }

    /**
     * @return string
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * @return FieldCollection
     */
    public function getFields() {
        return $this->fields;
    }
}