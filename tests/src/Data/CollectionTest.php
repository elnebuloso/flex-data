<?php
namespace FlexTest\Data;

use Flex\Data\Collection;

/**
 * Class CollectionTest
 *
 * @package FlexTest\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class CollectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return void
     */
    public function test_construct() {
        $collectionData = array(
            'foo',
            'bar'
        );
        $totalCount = 2;

        $collection = new Collection($collectionData, $totalCount);

        $this->assertEquals($collectionData, $collection->getElements());
        $this->assertEquals($totalCount, $collection->getTotalCount());
    }

    /**
     * @return void
     */
    public function test_elements() {
        $collectionData = array(
            'foo',
            'bar'
        );

        $collection = new Collection();
        $collection->setElements($collectionData);

        $this->assertEquals($collectionData, $collection->getElements());
    }

    /**
     * @return void
     */
    public function test_addElement() {
        $data = 'element';

        $collection = new Collection();
        $collection->addElement($data);
        $collection->addElement($data, 'foo');

        $elements = $collection->getElements();
        $this->assertEquals($data, $elements[0]);
        $this->assertEquals($data, $elements['foo']);
    }

    /**
     * @return void
     */
    public function test_totalCount() {
        $collection = new Collection();
        $collection->setTotalCount(2);

        $this->assertEquals(2, $collection->getTotalCount());
    }

    /**
     * @return void
     */
    public function test_countable() {
        $collectionData = array(
            'foo',
            'bar'
        );

        $collection = new Collection($collectionData);
        $this->assertEquals(2, $collection->count());
    }

    /**
     * @return void
     */
    public function test_arrayAccess() {
        $collectionData = array(
            'foo',
            'bar'
        );

        $collection = new Collection($collectionData);

        $this->assertEquals(true, $collection->offsetExists(0));
        $this->assertEquals(false, $collection->offsetExists(3));

        $this->assertEquals('foo', $collection->offsetGet(0));
        $this->assertEquals(null, $collection->offsetGet(2));

        $collection->offsetSet(null, 'baz');
        $this->assertEquals(true, $collection->offsetExists(2));

        $collection->offsetSet(3, 'foobaz');
        $this->assertEquals(true, $collection->offsetExists(3));

        $collection->offsetUnset(3);
        $this->assertEquals(false, $collection->offsetExists(3));
    }

    /**
     * @return void
     */
    public function test_toArray() {
        $object1 = new CollectionTestObject();
        $object2 = new CollectionTestObject();

        $collectionData = array(
            $object1,
            $object2,
            'foo'
        );

        $collection = new Collection($collectionData);
        $elements = $collection->toArray();

        $equals = array(
            array(
                'nickname' => 'foo'
            ),
            array(
                'nickname' => 'foo'
            ),
            'foo'
        );

        $this->assertEquals($equals, $elements);
    }

    /**
     * @return void
     */
    public function test_toJson() {
        $object1 = new CollectionTestObject();
        $object2 = new CollectionTestObject();

        $collectionData = array(
            $object1,
            $object2,
            'foo'
        );

        $equals = array(
            array(
                'nickname' => 'foo'
            ),
            array(
                'nickname' => 'foo'
            ),
            'foo'
        );
        $equals = json_encode($equals);

        $collection = new Collection($collectionData);
        $this->assertEquals($equals, $collection->toJson());
    }

    /**
     * @return void
     */
    public function test_iterator() {
        $collectionData = array(
            'foo',
            'bar',
            'baz'
        );

        $collection = new Collection($collectionData);

        $element = $collection->current();
        $this->assertEquals('foo', $element);

        $key = $collection->key();
        $this->assertEquals(0, $key);

        $element = $collection->next();
        $this->assertEquals('bar', $element);

        $valid = $collection->current();
        $this->assertEquals('bar', $element);

        $element = $collection->next();
        $this->assertEquals('baz', $element);

        $valid = $collection->valid();
        $this->assertEquals(true, $valid);

        $collection->rewind();
        $element = $collection->current();
        $this->assertEquals('foo', $element);
    }
}

/**
 * Class CollectionTestObject
 *
 * @package FlexTest\Data
 */
class CollectionTestObject extends Collection {

    /**
     * @return array
     */
    public function toArray() {
        return array(
            'nickname' => 'foo'
        );
    }
}