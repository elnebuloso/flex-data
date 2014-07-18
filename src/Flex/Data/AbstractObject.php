<?php
namespace Flex\Data;

use Exception;

/**
 * Class AbstractObject
 *
 * @package Flex\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
abstract class AbstractObject implements ToArrayInterface, ToJsonInterface {

    /**
     * @var Record
     */
    private $record;

    /**
     * @var bool
     */
    private $stored;

    /**
     * @param array $data
     * @param bool $stored
     */
    public function __construct(array $data = null, $stored = false) {
        $defaults = array('id' => null);

        $data = array_merge($defaults, (array) $data);

        $this->record = new Record($data);

        $this->setStored($stored);
        $this->init();
    }

    /**
     * @param bool $storeable
     */
    public function setStored($storeable) {
        $this->stored = $storeable;
    }

    /**
     * @return bool
     */
    public function isStored() {
        return $this->stored;
    }

    /**
     * @return void
     */
    public function init() {
        return null;
    }

    /**
     * @return array
     */
    public function __sleep() {
        return array('record');
    }

    /**
     * @return void
     */
    public function __wakeup() {
        $this->init();
    }

    /**
     * @param string $property
     * @throws Exception
     */
    public function __get($property) {
        throw new Exception("Trying to read unknown class property `" . get_class($this) . "::$property::`.");
    }

    /**
     * @param string $property
     * @param mixed $value
     * @throws Exception
     */
    public function __set($property, $value) {
        throw new Exception("Trying to write unknown class property `" . get_class($this) . "::$property::$value`.");
    }

    /**
     * @return Record
     */
    public function getRecord() {
        return $this->record;
    }

    /**
     * @return bool
     */
    public function isDirty() {
        return $this->record->isDirty();
    }

    /**
     * @param bool $dirty
     */
    public function setDirty($dirty) {
        $this->record->setDirty($dirty);
    }

    /**
     * @return array
     */
    public function toArray() {
        $data = $this->record->getData();

        foreach($data as &$value) {
            if($value instanceof ToArrayInterface) {
                $value = $value->toArray();
            }
        }

        return $data;
    }

    /**
     * @return string
     */
    public function toJson() {
        return json_encode($this->toArray());
    }

    /**
     * @return mixed the primary key
     */
    public function getId() {
        return $this->record->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->record->id = $id;
    }
}