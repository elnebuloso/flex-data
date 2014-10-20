<?php
namespace Flex\Data\ModelGenerator;

use Flex\Data\ModelGenerator\Entity\FieldCollection;
use Symfony\Component\Filesystem\Filesystem;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;

/**
 * Class Entity
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Entity {

    /**
     * @var string
     */
    private $root;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $name;

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
     * @param string $namespace
     */
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace() {
        return $this->namespace;
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
     * @param FieldCollection $fields
     */
    public function setFields(FieldCollection $fields) {
        $this->fields = $fields;
    }

    /**
     * @return FieldCollection
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * @param string $prepend
     * @param string $append
     * @return string
     */
    public function getClassName($prepend = null, $append = null) {
        $elements = explode('_', $this->getName());

        return $prepend . ucfirst(array_pop($elements)) . $append;
    }

    /**
     * @param string $prepend
     * @return string
     */
    public function getNamespaceName($prepend) {
        $elements = explode('_', $this->getName());
        array_pop($elements);
        array_unshift($elements, $prepend);
        array_unshift($elements, $this->getNamespace());

        return implode('\\', array_map('ucfirst', $elements));
    }

    /**
     * @return string
     */
    public function getAbstractModelFilename() {
        $elements[] = $this->getRoot();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('AbstractModel'));
        $elements[] = $this->getClassName('Abstract');

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }

    /**
     * @return string
     */
    public function getAbstractModelCollectionFilename() {
        $elements[] = $this->getRoot();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('AbstractModel'));
        $elements[] = $this->getClassName('Abstract', 'Collection');

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }

    /**
     * @return string
     */
    public function getModelFilename() {
        $elements[] = $this->getRoot();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('Model'));
        $elements[] = $this->getClassName(null);

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }

    /**
     * @return string
     */
    public function getModelCollectionFilename() {
        $elements[] = $this->getRoot();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('Model'));
        $elements[] = $this->getClassName(null, 'Collection');

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }

    /**
     * @return void
     */
    public function generateAbstractModel() {
        $class = new ClassGenerator();
        $class->setAbstract(true);
        $class->setName($this->getClassName('Abstract'));
        $class->setNamespaceName($this->getNamespaceName('AbstractModel'));
        $class->addUse('Flex\Data\AbstractObject');
        $class->setExtendedClass('AbstractObject');

        $fs = new Filesystem();
        $fs->mkdir(pathinfo($this->getAbstractModelFilename(), PATHINFO_DIRNAME));

        $generator = new FileGenerator();
        $generator->setClass($class);
        $generator->setFilename($this->getAbstractModelFilename());
        $generator->write();
    }

    /**
     * @return void
     */
    public function generateAbstractModelCollection() {
        $class = new ClassGenerator();
        $class->setAbstract(true);
        $class->setName($this->getClassName('Abstract', 'Collection'));
        $class->setNamespaceName($this->getNamespaceName('AbstractModel'));
        $class->addUse('Flex\Data\Collection');
        $class->setExtendedClass('Collection');

        $fs = new Filesystem();
        $fs->mkdir(pathinfo($this->getAbstractModelCollectionFilename(), PATHINFO_DIRNAME));

        $generator = new FileGenerator();
        $generator->setClass($class);
        $generator->setFilename($this->getAbstractModelCollectionFilename());
        $generator->write();
    }

    /**
     * @return void
     */
    public function generateModel() {
        $class = new ClassGenerator();
        $class->setName($this->getClassName(null));
        $class->setNamespaceName($this->getNamespaceName('Model'));
        $class->addUse($this->getNamespaceName('AbstractModel') . '\\' . $this->getClassName('Abstract'));
        $class->setExtendedClass($this->getClassName('Abstract'));

        if(!file_exists($this->getModelFilename())) {
            $fs = new Filesystem();
            $fs->mkdir(pathinfo($this->getModelFilename(), PATHINFO_DIRNAME));
        }

        $generator = new FileGenerator();
        $generator->setClass($class);
        $generator->setFilename($this->getModelFilename());
        $generator->write();
    }

    /**
     * @return void
     */
    public function generateModelCollection() {
        $class = new ClassGenerator();
        $class->setName($this->getClassName(null, 'Collection'));
        $class->setNamespaceName($this->getNamespaceName('Model'));
        $class->addUse($this->getNamespaceName('AbstractModel') . '\\' . $this->getClassName('Abstract', 'Collection'));
        $class->setExtendedClass($this->getClassName('Abstract', 'Collection'));

        if(!file_exists($this->getModelCollectionFilename())) {
            $fs = new Filesystem();
            $fs->mkdir(pathinfo($this->getModelCollectionFilename(), PATHINFO_DIRNAME));
        }

        $generator = new FileGenerator();
        $generator->setClass($class);
        $generator->setFilename($this->getModelCollectionFilename());
        $generator->write();
    }
}