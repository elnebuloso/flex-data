<?php
namespace FlexTest\Data;

use FlexTest\Data\AbstractRecursiveObjectTest\User;

/**
 * Class AbstractRecursiveObjectTest
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class AbstractRecursiveObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @test
     */
    public function testGetFirstname()
    {
        $this->user = new User();
        $this->assertEquals('John', $this->user->getFirstname());
    }

    /**
     * @test
     */
    public function testGetLocation()
    {
        $this->user = new User();
        $this->assertInternalType('array', $this->user->getLocation());
    }

    /**
     * @test
     */
    public function testGetLocationCity()
    {
        $this->user = new User();
        $this->assertEquals('Berlin', $this->user->getLocationCity());
    }

    /**
     * @test
     */
    public function testGetLocationGeoLat()
    {
        $this->user = new User();
        $this->assertEquals('51.0000', $this->user->getLocationGeoLat());
    }

    /**
     * @test
     */
    public function testGetMissingDefaultNull()
    {
        $this->user = new User();
        $this->assertNull($this->user->getRecordValue('foo/bar/baz'));
    }

    /**
     * @test
     */
    public function testGetMissingDefaultValue()
    {
        $this->user = new User();
        $this->assertEquals('testDefault', $this->user->getRecordValue('foo/bar/baz', 'testDefault'));
    }

    /**
     * @test
     */
    public function testSetNewValue()
    {
        $this->user = new User();
        $this->user->setRecordValue('foo/bar/baz', '123456789');
        $this->assertEquals('123456789', $this->user->getRecordValue('foo/bar/baz'));
    }

    /**
     * @test
     */
    public function testSetUpdateValue()
    {
        $this->user = new User();
        $this->assertEquals('Berlin', $this->user->getLocationCity());
        $this->user->setRecordValue('location/city', '123456789');
        $this->assertEquals('123456789', $this->user->getLocationCity());
    }

    /**
     * @test
     */
    public function testToArray()
    {
        $expected = array(
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'group'     => array(
                'name' => 'group1'
            ),
            'location'  => array(
                'city' => 'Berlin',
                'geo'  => array(
                    'lat' => '51.0000',
                    'lon' => '8.0000'
                )
            )
        );

        $this->user = new User();
        $this->assertEquals($expected, $this->user->toArray());
    }

    /**
     * @test
     */
    public function testToJson()
    {
        $expected = array(
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'group'     => array(
                'name' => 'group1'
            ),
            'location'  => array(
                'city' => 'Berlin',
                'geo'  => array(
                    'lat' => '51.0000',
                    'lon' => '8.0000'
                )
            )
        );

        $this->user = new User();
        $this->assertEquals(json_encode($expected), $this->user->toJson());
    }
}
