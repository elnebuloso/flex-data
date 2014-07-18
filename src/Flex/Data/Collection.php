<?php
namespace Flex\Data;

/**
 * Class Collection
 *
 * @package Flex\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Collection implements \Iterator, \ArrayAccess, \Countable, ToArrayInterface, ToJsonInterface {

    /**
     * @var array
     */
    private $elements = array();

    /**
     * @var int
     */
    private $totalCount;

    /**
     * @param array $elements
     * @param int $totalCount
     */
    public function __construct(array $elements = array(), $totalCount = null) {
        $this->elements = $elements;
        $this->totalCount = $totalCount;
    }

    /**
     * @return array
     */
    public function getElements() {
        return $this->elements;
    }

    /**
     * @param array $elements
     */
    public function setElements(array $elements) {
        $this->elements = $elements;
    }

    /**
     * @param mixed $element
     * @param mixed $id
     */
    public function addElement($element, $id = null) {
        if(!is_null($id)) {
            $this->elements[$id] = $element;
        }
        else {
            $this->elements[] = $element;
        }
    }

    /**
     * @return int
     */
    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount($totalCount) {
        $this->totalCount = $totalCount;
    }

    /**
     * @return array
     */
    public function toArray() {
        $elements = array();

        foreach($this->elements as $element) {
            if(is_object($element)) {
                if($element instanceof ToArrayInterface) {
                    $elements[] = $element->toArray();
                }
            }
            else {
                $elements[] = $element;
            }
        }

        return $elements;
    }

    /**
     * @return string
     */
    public function toJson() {
        return json_encode($this->toArray());
    }

    /**
     * @return mixed
     */
    public function key() {
        return key($this->elements);
    }

    /**
     * @return mixed
     */
    public function next() {
        return next($this->elements);
    }

    /**
     * @return void
     */
    public function rewind() {
        reset($this->elements);
    }

    /**
     * @return bool
     */
    public function valid() {
        return $this->current() !== false;
    }

    /**
     * @return mixed
     */
    public function current() {
        return current($this->elements);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->elements[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return isset($this->elements[$offset]) ? $this->elements[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        if(is_null($offset)) {
            $this->elements[] = $value;
        }
        else {
            $this->elements[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        if(array_key_exists($offset, $this->elements)) {
            unset($this->elements[$offset]);
        }
    }

    /**
     * @return int
     */
    public function count() {
        return count($this->elements);
    }
}