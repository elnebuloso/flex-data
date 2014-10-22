<?php
namespace Flex\Data\ModelGenerator\Entity;

use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;

/**
 * Class FieldGenerator
 *
 * @package Flex\Data\ModelGenerator\Entity
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class FieldGenerator {

    /**
     * @var Field
     */
    private $field;

    /**
     * @param Field $field
     */
    public function __construct(Field $field) {
        $this->field = $field;
    }

    /**
     * @return MethodGenerator
     */
    public function getSetterMethod() {
        $method = new MethodGenerator();
        $method->setName('set' . ucfirst($this->field->getPhpName()));

        return $method;
    }

    /**
     * @return MethodGenerator
     */
    public function getGetterMethod() {
        $method = new MethodGenerator();
        $method->setName('get' . ucfirst($this->field->getPhpName()));
        $method->setBody('return $this->record->' . $this->field->getName() . ';');

        $docBlockTag = new ReturnTag();
        $docBlockTag->setTypes($this->field->getPhpType());

        $docBlock = new DocBlockGenerator();
        $docBlock->setTag($docBlockTag);

        $method->setDocBlock($docBlock);

        return $method;
    }
}