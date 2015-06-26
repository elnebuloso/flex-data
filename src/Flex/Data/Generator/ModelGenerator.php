<?php
namespace Flex\Data\Generator;

use Exception;
use Flex\Data\Generator\Code\EntityGenerator;

/**
 * Class ModelGenerator
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class ModelGenerator
{

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $target;

    /**
     * @var EntityCollection
     */
    private $entities;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->entities = new EntityCollection();
    }

    /**
     * @param string $namespace
     * @throws Exception
     */
    public function setNamespace($namespace)
    {
        $this->namespace = trim($namespace);

        if (empty($this->namespace)) {
            throw new Exception('namespace cannot be empty', 1000);
        }
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $target
     * @throws Exception
     */
    public function setTarget($target)
    {
        $this->target = realpath($target);

        if ($this->target === false) {
            throw new Exception('invalid path to model output: ' . $target, 1000);
        }
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return EntityCollection
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @return void
     */
    public function generate()
    {
        foreach ($this->getEntities() as $entity) {
            /** @var Entity $entity */
            $generator = new EntityGenerator($entity);
            $generator->generate();
        }
    }
}
