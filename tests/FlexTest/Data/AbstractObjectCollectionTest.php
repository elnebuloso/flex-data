<?php
namespace FlexTest\Data;

use Flex\Data\AbstractObject;
use Flex\Data\AbstractObjectCollection;

/**
 * Class AbstractObjectCollectionTest
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class AbstractObjectCollectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getObjects() {
        $mockMethods = array(
            'getElements'
        );

        $collection = $this->getMockBuilder('Flex\Data\AbstractObjectCollection')->setMethods($mockMethods)->getMockForAbstractClass();
        $collection->expects($this->once())->method('getElements')->will($this->returnValue(array()));
        $collection->getObjects();
    }

    /**
     * @test
     */
    public function setObjects() {
        $mockMethods = array(
            'setElements'
        );

        $collection = $this->getMockBuilder('Flex\Data\AbstractObjectCollection')->setMethods($mockMethods)->getMockForAbstractClass();
        $collection->expects($this->once())->method('setElements')->with(array());
        $collection->setObjects(array());
    }

    /**
     * @test
     */
    public function addObject() {
        $mockMethods = array(
            'addElement'
        );

        $collection = $this->getMockBuilder('Flex\Data\AbstractObjectCollection')->setMethods($mockMethods)->getMockForAbstractClass();
        $object = new AbstractObjectCollectionTest_Object(array(
            'id' => 1,
            'nickname' => 'foo'
        ));

        $collection->expects($this->once())->method('addElement')->with($object);
        $collection->addObject($object);
    }
}

class AbstractObjectCollectionTest_Collection extends AbstractObjectCollection {

}

class AbstractObjectCollectionTest_Object extends AbstractObject {

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