<?php
namespace Flex\Data;

use Exception;

/**
 * Class AbstractObject
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
abstract class AbstractObject implements ToArrayInterface, ToJsonInterface {

    /**
     * @var Record
     */
    private $record;

    /**
     * @param array $data
     */
    public function __construct(array $data = array()) {
        $this->record = new Record($data);
        $this->init();
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
}