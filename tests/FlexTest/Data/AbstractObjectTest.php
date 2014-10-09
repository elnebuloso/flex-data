<?php
namespace FlexTest\Data;

use Flex\Data\AbstractObject;

/**
 * Class AbstractObjectTest
 *
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
            'name' => 'foo',
            'user' => array(
                'name' => 'bar'
            )
        );

        $foo = new TestUser();
        $foo->setName('foo');

        $bar = new TestUser();
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toArray());
    }

    /**
     * @test
     */
    public function toJsonWithToJsonInterfaceObject() {
        $expected = array(
            'name' => 'foo',
            'user' => array(
                'name' => 'bar'
            )
        );
        $expected = json_encode($expected);

        $foo = new TestUser();
        $foo->setName('foo');

        $bar = new TestUser();
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toJson());
    }
}

/**
 * Class AbstractObjectTestObject
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
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
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
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