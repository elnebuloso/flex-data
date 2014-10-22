<?php
namespace Flex\Data\ModelGenerator\Entity;

use Flex\Data\Collection;

/**
 * Class FieldCollection
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class FieldCollection extends Collection {

    /**
     * @return array
     */
    public function getDefaults() {
        $defaults = array();

        foreach($this->getElements() as $field) {
            /** @var Field $field */
            $defaults[$field->getName()] = null;

            if($field->getDefaultValue() != '') {
                $defaultValue = $field->getDefaultValue();

                switch($field->getPhpType()) {
                    case 'int':
                    case 'float':
                    case 'string':
                    case 'null':
                        settype($defaultValue, $field->getPhpType());
                        break;

                    default:
                        settype($defaultValue, 'string');
                        break;
                }

                if($field->getPhpType() == 'bool') {
                    $defaultValue = $field->getDefaultValue() == 'true' ? true : false;
                }

                if($field->getPhpType() == '\DateTime') {
                    $defaultValue = null;
                }

                $defaults[$field->getName()] = $defaultValue;
            }
        }

        return $defaults;
    }
}