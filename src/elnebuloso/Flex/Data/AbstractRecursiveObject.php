<?php
namespace elnebuloso\Flex\Data;

use elnebuloso\Flex\HasToArray;
use elnebuloso\Flex\HasToJson;

/**
 * Class AbstractRecursiveObject
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
abstract class AbstractRecursiveObject implements HasToArray, HasToJson
{
    /**
     * @var array
     */
    private $record;

    /**
     * @param array $record
     */
    public function __construct(array $record = [])
    {
        $this->record = array_merge($this->getRecordDefaults(), $record);
    }

    /**
     * @param string $path
     * @param mixed $value
     */
    public function setRecordValue($path, $value)
    {
        $elements = explode('/', $path);
        $record = $this->record;

        $this->createNestedEntry($record, $elements, $value);
        $this->record = $record;
    }

    /**
     * @param string $path
     * @param mixed $default
     * @return mixed|null
     */
    public function getRecordValue($path, $default = null)
    {
        $elements = explode('/', $path);
        $result = $this->record;

        foreach ($elements as $element) {
            if (!array_key_exists($element, $result)) {
                return $default;
            }

            $result = $result[$element];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->record;

        foreach ($data as &$value) {
            if ($value instanceof HasToArray) {
                $value = $value->toArray();
            }
        }

        return $data;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return array
     */
    abstract public function getRecordDefaults();

    /**
     * @param array $array
     * @param array $keys
     * @param mixed $value
     */
    private function createNestedEntry(&$array, array $keys, $value)
    {
        $last = array_pop($keys);

        foreach ($keys as $key) {
            if (!array_key_exists($key, $array) || (array_key_exists($key, $array) && !is_array($array[$key]))) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[$last] = $value;
    }
}
