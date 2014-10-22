<?php
namespace Flex\Data\ModelGenerator\Entity;

use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ParameterGenerator;

/**
 * Class FieldGenerator
 *
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
        $docBlockTag = new ParamTag();
        $docBlockTag->setTypes($this->field->getPhpType());
        $docBlockTag->setVariableName($this->field->getPhpName());

        $docBlock = new DocBlockGenerator();
        $docBlock->setTag($docBlockTag);

        $parameter = new ParameterGenerator();
        $parameter->setName($this->field->getPhpName());

        if($this->field->getPhpTypeHinting()) {
            $parameter->setType($this->field->getPhpType());
        }

        $method = new MethodGenerator();
        $method->setName('set' . ucfirst($this->field->getPhpName()));
        $method->setParameter($parameter);
        $method->setBody('$this->record->' . $this->field->getName() . ' = $' . $this->field->getPhpName() . ';');
        $method->setDocBlock($docBlock);

        return $method;
    }

    /**
     * @return MethodGenerator
     */
    public function getGetterMethod() {
        $docBlockTag = new ReturnTag();
        $docBlockTag->setTypes($this->field->getPhpType());

        $docBlock = new DocBlockGenerator();
        $docBlock->setTag($docBlockTag);

        $method = new MethodGenerator();
        $method->setName('get' . ucfirst($this->field->getPhpName()));
        $method->setBody('return $this->record->' . $this->field->getName() . ';');
        $method->setDocBlock($docBlock);

        return $method;
    }
}