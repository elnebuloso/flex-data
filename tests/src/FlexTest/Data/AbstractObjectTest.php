<?php
namespace elnebuloso\FlexTest\Data;

use elnebuloso\FlexTest\Data\AbstractObjectTest\Object;
use elnebuloso\FlexTest\Data\AbstractObjectTest\User;
use PHPUnit_Framework_TestCase;

/**
 * Class AbstractObjectTest
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class AbstractObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $values;

    /**
     * @var Object
     */
    private $object;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->values = [
            'nickname' => 'foo',
        ];

        $this->object = new Object($this->values);
    }

    /**
     * @test
     */
    public function testIsDirty()
    {
        $this->assertEquals(false, $this->object->isDirty());
        $this->object->setNickname('bar');
        $this->assertEquals(true, $this->object->isDirty());

        $this->object->setDirty(false);
        $this->assertEquals(false, $this->object->isDirty());
    }

    /**
     * @test
     */
    public function testSleep()
    {
        $data = $this->object->__sleep();
        $this->assertEquals(['record'], $data);
    }

    /**
     * @test
     */
    public function testWakeup()
    {
        $mockMethods = [
            'init',
        ];

        $object = $this->getMockBuilder('\elnebuloso\Flex\Data\AbstractObject')->setMethods($mockMethods)->getMockForAbstractClass();
        $object->expects($this->once())->method('init');

        /** @var \elnebuloso\Flex\Data\AbstractObject $object */
        $object->__wakeup();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPropertyNotExisting()
    {
        $this->object->lastname;
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testSetPropertyNotExisting()
    {
        $this->object->lastname = 'foo';
    }

    /**
     * @test
     */
    public function testToArray()
    {
        $this->assertEquals($this->values, $this->object->toArray());
    }

    /**
     * @test
     */
    public function testToArrayWithToArrayInterfaceObject()
    {
        $expected = [
            'name' => 'foo',
            'user' => [
                'name' => 'bar',
            ],
        ];

        $foo = new User();
        $foo->setName('foo');

        $bar = new User();
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toArray());
    }

    /**
     * @test
     */
    public function testToJsonWithToJsonInterfaceObject()
    {
        $expected = [
            'name' => 'foo',
            'user' => [
                'name' => 'bar',
            ],
        ];
        $expected = json_encode($expected);

        $foo = new User();
        $foo->setName('foo');

        $bar = new User();
        $bar->setName('bar');

        $foo->setUser($bar);

        $this->assertEquals($expected, $foo->toJson());
    }
}
