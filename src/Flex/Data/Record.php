<?php
namespace Flex\Data;

use stdClass;

/**
 * Class Record
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Record extends stdClass
{
    /**
     * @var array
     */
    private $data = array();

    /**
     * @var bool
     */
    private $dirty = false;

    /**
     * @var array
     */
    private $changes = array();

    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if (!is_null($data)) {
            $this->data = $data;
        }
    }

    /**
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (!array_key_exists($property, $this->data)) {
            return null;
        }

        return $this->data[$property];
    }

    /**
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        if (array_key_exists($property, $this->data) && $this->data[$property] != $value) {
            $this->dirty = true;
            $this->changes[$property] = $this->data[$property];
        }

        $this->data[$property] = $value;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return array(
            'data',
            'dirty',
            'changes'
        );
    }

    /**
     * @param bool $dirty
     */
    public function setDirty($dirty)
    {
        $this->dirty = $dirty;

        if (!$dirty) {
            $this->changes = array();
        }
    }

    /**
     * @return bool
     */
    public function isDirty()
    {
        return $this->dirty;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getChanges()
    {
        $changes = array();

        foreach (array_keys($this->changes) as $id) {
            if (array_key_exists($id, $this->data)) {
                $changes[$id] = $this->data[$id];
            }
        }

        return $changes;
    }

    /**
     * @param string $property
     * @return mixed
     */
    public function getValue($property)
    {
        if (!array_key_exists($property, $this->data)) {
            return null;
        }

        return $this->data[$property];
    }

    /**
     * @param string $key
     */
    public function unsetProperty($key)
    {
        if (array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
        }
    }
}
