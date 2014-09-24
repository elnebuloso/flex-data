<?php
namespace FlexTest\Data;

use Flex\Data\AbstractObject;

/**
 * Class AbstractObjectTest
 *
 * @package FlexTest\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class AbstractObjectTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var array
     */
    private $values;

    /**
     * @var AbstractObjectTestObject
     */
    private $object;

    /**
     * @return void
     */
    public function setUp() {
        parent::setUp();

        $this->values = array(
            'id' => 1,
            'nickname' => 'foo'
        );
        $this->object = new AbstractObjectTestObject($this->values);
    }

    /**
     * @return void
     */
    public function tearDown() {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getRecord() {
        $record = $this->object->getRecord();
        $this->assertInstanceOf('\Flex\Data\Record', $record);
    }

    /**
     * @test
     */
    public function isDirty() {
        $this->assertEquals(false, $this->object->isDirty());
        $this->object->setNickname('bar');
        $this->assertEquals(true, $this->object->isDirty());

        $this->object->setDirty(false);
        $this->assertEquals(false, $this->object->isDirty());
    }

    /**
     * @test
     */
    public function sleep() {
        $data = $this->object->__sleep();
        $this->assertEquals(array(
            'record'
        ), $data);
    }

    /**
     * @test
     */
    public function wakeup() {
        $mockMethods = array(
            'init'
        );

        $object = $this->getMockBuilder('Flex\Data\AbstractObject')->setMethods($mockMethods)->getMockForAbstractClass();

        $object->expects($this->once())->method('init');
        $object->__wakeup();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function getPropertyNotExisting() {
        $this->object->lastname;
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function setPropertyNotExisting() {
        $this->object->lastname = 'foo';
    }

    /**
     * @test
     */
    public function toArray() {
        $this->assertEquals($this->values, $this->object->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithToArrayInterfaceObject() {
        $expected = array(
            'id' => 1,
            'name' => 'foo',
            'user' => array(
                'id' => 2,
                'name' => 'bar'
            )
        );

        $foo = new TestUser();
        $foo->setId(1);
        $foo->setName('foo');

        $bar = new TestUser();
        $bar->setId(2);
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toArray());
    }

    /**
     * @test
     */
    public function toJsonWithToJsonInterfaceObject() {
        $expected = array(
            'id' => 1,
            'name' => 'foo',
            'user' => array(
                'id' => 2,
                'name' => 'bar'
            )
        );
        $expected = json_encode($expected);

        $foo = new TestUser();
        $foo->setId(1);
        $foo->setName('foo');

        $bar = new TestUser();
        $bar->setId(2);
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toJson());
    }

    /**
     * @test
     */
    public function isSaved() {
        $values = array(
            'id' => 1,
            'nickname' => 'foo'
        );

        $object = new AbstractObjectTestObject($values, false);
        $this->assertEquals(false, $object->isSaved());

        $object->setSaved(true);
        $this->assertEquals(true, $object->isSaved());
    }

    /**
     * @test
     */
    public function setId() {
        $object = new AbstractObjectTestObject(array(), false);
        $this->assertEquals(null, $object->getId());

        $expected = uniqid();
        $object->setId($expected);
        $this->assertEquals($expected, $object->getId());
    }
}

/**
 * Class AbstractObjectTestObject
 *
 * @package FlexTest\Data
 */
class AbstractObjectTestObject extends AbstractObject {

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

/**
 * Class TestUser
 *
 * @package FlexTest\Data
 */
class TestUser extends AbstractObject {

    /**
     * @return string
     */
    public function getName() {
        return $this->getRecord()->name;
    }

    /**
     * @param $name
     */
    public function setName($name) {
        $this->getRecord()->name = $name;
    }

    /**
     * @param $user
     */
    public function setUser($user) {
        $this->getRecord()->user = $user;
    }
}