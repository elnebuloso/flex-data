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
     * @var AbstractObjectTest_Object
     */
    private $object;

    /**
     * @return void
     */
    public function setUp() {
        $this->values = array(
            'nickname' => 'foo'
        );

        $this->object = new AbstractObjectTest_Object($this->values);
    }

    /**
     * @test
     */
    public function test_isDirty() {
        $this->assertEquals(false, $this->object->isDirty());
        $this->object->setNickname('bar');
        $this->assertEquals(true, $this->object->isDirty());

        $this->object->setDirty(false);
        $this->assertEquals(false, $this->object->isDirty());
    }

    /**
     * @test
     */
    public function test_sleep() {
        $data = $this->object->__sleep();
        $this->assertEquals(array(
            'record'
        ), $data);
    }

    /**
     * @test
     */
    public function test_wakeup() {
        $mockMethods = array(
            'init'
        );

        $object = $this->getMockBuilder('Flex\Data\AbstractObject')->setMethods($mockMethods)->getMockForAbstractClass();
        $object->expects($this->once())->method('init');

        /** @var \Flex\Data\AbstractObject $object */
        $object->__wakeup();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function test_getPropertyNotExisting() {
        $this->object->lastname;
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function test_setPropertyNotExisting() {
        $this->object->lastname = 'foo';
    }

    /**
     * @test
     */
    public function test_toArray() {
        $this->assertEquals($this->values, $this->object->toArray());
    }

    /**
     * @test
     */
    public function test_toArrayWithToArrayInterfaceObject() {
        $expected = array(
            'name' => 'foo',
            'user' => array(
                'name' => 'bar'
            )
        );

        $foo = new AbstractObjectTest_User();
        $foo->setName('foo');

        $bar = new AbstractObjectTest_User();
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toArray());
    }

    /**
     * @test
     */
    public function test_toJsonWithToJsonInterfaceObject() {
        $expected = array(
            'name' => 'foo',
            'user' => array(
                'name' => 'bar'
            )
        );
        $expected = json_encode($expected);

        $foo = new AbstractObjectTest_User();
        $foo->setName('foo');

        $bar = new AbstractObjectTest_User();
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toJson());
    }
}

class AbstractObjectTest_Object extends AbstractObject {

    /**
     * @return string
     */
    public function getNickname() {
        return $this->record->nickname;
    }

    /**
     * @param string $v
     */
    public function setNickname($v) {
        $this->record->nickname = $v;
    }
}

class AbstractObjectTest_User extends AbstractObject {

    /**
     * @return string
     */
    public function getName() {
        return $this->record->name;
    }

    /**
     * @param $name
     */
    public function setName($name) {
        $this->record->name = $name;
    }

    /**
     * @param $user
     */
    public function setUser($user) {
        $this->record->user = $user;
    }
}