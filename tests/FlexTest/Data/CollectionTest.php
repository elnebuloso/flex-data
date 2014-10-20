<?php
namespace FlexTest\Data;

use Flex\Data\Collection;

/**
 * Class CollectionTest
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class CollectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function construct() {
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
     * @test
     */
    public function elements() {
        $collectionData = array(
            'foo',
            'bar'
        );

        $collection = new Collection();
        $collection->setElements($collectionData);

        $this->assertEquals($collectionData, $collection->getElements());
    }

    /**
     * @test
     */
    public function addElement() {
        $data = 'element';

        $collection = new Collection();
        $collection->addElement($data);
        $collection->addElement($data, 'foo');

        $elements = $collection->getElements();
        $this->assertEquals($data, $elements[0]);
        $this->assertEquals($data, $elements['foo']);
    }

    /**
     * @test
     */
    public function getElement() {
        $data = 'element';

        $collection = new Collection();
        $collection->addElement($data, 'foo');

        $this->assertEquals('element', $collection->getElement('foo'));
        $this->assertNull($collection->getElement('bar'));
    }

    /**
     * @test
     */
    public function removeElement() {
        $data = 'element';

        $collection = new Collection();
        $collection->addElement($data, 'foo');
        $collection->addElement($data, 'bar');
        $collection->removeElement('bar');

        $elements = $collection->getElements();
        $this->assertEquals($elements, array(
            'foo' => 'element'
        ));
    }

    /**
     * @test
     */
    public function totalCount() {
        $collection = new Collection();
        $collection->setTotalCount(2);

        $this->assertEquals(2, $collection->getTotalCount());
    }

    /**
     * @test
     */
    public function countable() {
        $collectionData = array(
            'foo',
            'bar'
        );

        $collection = new Collection($collectionData);
        $this->assertEquals(2, $collection->count());
    }

    /**
     * @test
     */
    public function arrayAccess() {
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
     * @test
     */
    public function toArray() {
        $object1 = new CollectionTest_Collection();
        $object2 = new CollectionTest_Collection();

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
     * @test
     */
    public function toJson() {
        $object1 = new CollectionTest_Collection();
        $object2 = new CollectionTest_Collection();

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
     * @test
     */
    public function iterator() {
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

class CollectionTest_Collection extends Collection {

    /**
     * @return array
     */
    public function toArray() {
        return array(
            'nickname' => 'foo'
        );
    }
}