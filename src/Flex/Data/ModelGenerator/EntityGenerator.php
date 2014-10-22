<?php
namespace Flex\Data\ModelGenerator;

use Flex\Data\ModelGenerator\Entity\Field;
use Flex\Data\ModelGenerator\Entity\FieldGenerator;
use Symfony\Component\Filesystem\Filesystem;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;

/**
 * Class EntityGenerator
 *
 * @package Flex\Data\ModelGenerator
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class EntityGenerator {

    /**
     * @var Entity
     */
    private $entity;

    /**
     * @param Entity $entity
     */
    public function __construct(Entity $entity) {
        $this->entity = $entity;
    }

    /**
     * @return void
     */
    public function generate() {
        $this->generateAbstractModelCollection();
        $this->generateAbstractModel();
        $this->generateModelCollection();
        $this->generateModel();
    }

    /**
     * @return void
     */
    public function generateAbstractModel() {
        $docBlock = new DocBlockGenerator();
        $docBlock->setTag(array(
            'name' => 'author',
            'description' => 'elnebuloso/flex-data (Model Generator)'
        ));

        $class = new ClassGenerator();
        $class->setAbstract(true);
        $class->setName($this->getClassName('Abstract'));
        $class->setNamespaceName($this->getNamespaceName('AbstractModel'));
        $class->addUse('Flex\Data\AbstractObject');
        $class->setExtendedClass('AbstractObject');
        $class->setDocBlock($docBlock);

        foreach($this->entity->getFields() as $field) {
            /** @var Field $field */
            $fieldGenerator = new FieldGenerator($field);
            $class->addMethodFromGenerator($fieldGenerator->getSetterMethod());
            $class->addMethodFromGenerator($fieldGenerator->getGetterMethod());
        }

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
        $docBlock = new DocBlockGenerator();
        $docBlock->setTag(array(
            'name' => 'author',
            'description' => 'elnebuloso/flex-data (Model Generator)'
        ));

        $class = new ClassGenerator();
        $class->setAbstract(true);
        $class->setName($this->getClassName('Abstract', 'Collection'));
        $class->setNamespaceName($this->getNamespaceName('AbstractModel'));
        $class->addUse('Flex\Data\Collection');
        $class->setExtendedClass('Collection');
        $class->setDocBlock($docBlock);

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
        $docBlock = new DocBlockGenerator();
        $docBlock->setTag(array(
            'name' => 'author',
            'description' => 'elnebuloso/flex-data (Model Generator)'
        ));

        $class = new ClassGenerator();
        $class->setName($this->getClassName(null));
        $class->setNamespaceName($this->getNamespaceName('Model'));
        $class->addUse($this->getNamespaceName('AbstractModel') . '\\' . $this->getClassName('Abstract'));
        $class->setExtendedClass($this->getClassName('Abstract'));
        $class->setDocBlock($docBlock);

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
        $docBlock = new DocBlockGenerator();
        $docBlock->setTag(array(
            'name' => 'author',
            'description' => 'elnebuloso/flex-data (Model Generator)'
        ));

        $class = new ClassGenerator();
        $class->setName($this->getClassName(null, 'Collection'));
        $class->setNamespaceName($this->getNamespaceName('Model'));
        $class->addUse($this->getNamespaceName('AbstractModel') . '\\' . $this->getClassName('Abstract', 'Collection'));
        $class->setExtendedClass($this->getClassName('Abstract', 'Collection'));
        $class->setDocBlock($docBlock);

        if(!file_exists($this->getModelCollectionFilename())) {
            $fs = new Filesystem();
            $fs->mkdir(pathinfo($this->getModelCollectionFilename(), PATHINFO_DIRNAME));
        }

        $generator = new FileGenerator();
        $generator->setClass($class);
        $generator->setFilename($this->getModelCollectionFilename());
        $generator->write();
    }

    /**
     * @param string $prepend
     * @param string $append
     * @return string
     */
    private function getClassName($prepend = null, $append = null) {
        $elements = explode('\\', $this->entity->getClassName());

        return $prepend . ucfirst(array_pop($elements)) . $append;
    }

    /**
     * @param string $prepend
     * @return string
     */
    private function getNamespaceName($prepend) {
        $elements = explode('\\', $this->entity->getClassName());
        array_pop($elements);
        array_unshift($elements, $prepend);
        array_unshift($elements, $this->entity->getNamespace());

        return implode('\\', array_map('ucfirst', $elements));
    }

    /**
     * @return string
     */
    private function getAbstractModelFilename() {
        $elements[] = $this->entity->getTarget();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('AbstractModel'));
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getClassName('Abstract'));

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }

    /**
     * @return string
     */
    private function getAbstractModelCollectionFilename() {
        $elements[] = $this->entity->getTarget();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('AbstractModel'));
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getClassName('Abstract', 'Collection'));

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }

    /**
     * @return string
     */
    private function getModelFilename() {
        $elements[] = $this->entity->getTarget();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('Model'));
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getClassName(null));

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }

    /**
     * @return string
     */
    private function getModelCollectionFilename() {
        $elements[] = $this->entity->getTarget();
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespaceName('Model'));
        $elements[] = str_replace('\\', DIRECTORY_SEPARATOR, $this->getClassName(null, 'Collection'));

        return implode(DIRECTORY_SEPARATOR, $elements) . '.php';
    }
}