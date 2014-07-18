<?php
namespace FlexTest\Data;

use Flex\Data\AbstractObject;
use Flex\Data\AbstractObjectCollection;

/**
 * Class AbstractObjectCollectionTest
 *
 * @package FlexTest\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class AbstractObjectCollectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return void
     */
    public function test_getObjects() {
        $mockMethods = array(
            'getElements'
        );

        $collection = $this->getMockBuilder('Flex\Data\AbstractObjectCollection')->setMethods($mockMethods)->getMockForAbstractClass();
        $collection->expects($this->once())->method('getElements')->will($this->returnValue(array()));
        $collection->getObjects();
    }

    /**
     * @return void
     */
    public function test_setObjects() {
        $mockMethods = array(
            'setElements'
        );

        $collection = $this->getMockBuilder('Flex\Data\AbstractObjectCollection')->setMethods($mockMethods)->getMockForAbstractClass();
        $collection->expects($this->once())->method('setElements')->with(array());
        $collection->setObjects(array());
    }

    /**
     * @return void
     */
    public function test_addObject() {
        $mockMethods = array(
            'addElement'
        );

        $collection = $this->getMockBuilder('Flex\Data\AbstractObjectCollection')->setMethods($mockMethods)->getMockForAbstractClass();
        $object = new AbstractObjectCollectionTestObject(array(
            'id' => 1,
            'nickname' => 'foo'
        ));

        $collection->expects($this->once())->method('addElement')->with($object, 1);
        $collection->addObject($object);
    }

    /**
     * @return void
     */
    public function test_getAdditional() {
        $object = new AbstractObjectCollectionTestObject(array(
            'id' => 1,
            'nickname' => 'foo'
        ));

        $collection = new AbstractObjectCollectionTestCollection();
        $collection->addObject($object, array(
            'additional_foo'
        ));

        $this->assertEquals(array(
            'additional_foo'
        ), $collection->getAdditional($object));
    }
}

/**
 * Class AbstractObjectCollectionTestCollection
 *
 * @package FlexTest\Data
 */
class AbstractObjectCollectionTestCollection extends AbstractObjectCollection {

}

/**
 * Class AbstractObjectCollectionTestObject
 *
 * @package FlexTest\Data
 */
class AbstractObjectCollectionTestObject extends AbstractObject {

    /**
     * @return mixed
     */
    public function getId() {
        return $this->getRecord()->id;
    }

    /**
     * @param mixed $v
     */
    public function setId($v) {
        $this->getRecord()->id = $v;
    }

    /**
     * @return string
     */
    public function getNickname() {
        return $this->getRecord()->nickname;
    }

    /**
     * @param string $v
     */
    public function setNickname($v) {
        $this->getRecord()->nickname = $v;
    }
}