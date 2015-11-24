<?php
namespace FlexTest\Data;

use Flex\Data\Record;

/**
 * Class RecordTest
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class RecordTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testConstructorEmptyData()
    {
        $storage = new Record();
        $storage->nickname = 'foo';

        $this->assertEquals('foo', $storage->nickname);
    }

    /**
     * @test
     */
    public function testConstructorWithData()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $this->assertEquals('foo', $storage->nickname);
    }

    /**
     * @test
     */
    public function testConstructorEmptyDataDirty()
    {
        $storage = new Record();
        $this->assertEquals(false, $storage->isDirty());
    }

    /**
     * @test
     */
    public function testConstructorWithDataDirty()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $this->assertEquals(false, $storage->isDirty());
    }

    /**
     * @test
     */
    public function testIsDirty()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $this->assertEquals(false, $storage->isDirty());
        $storage->nickname = 'bar';
        $this->assertEquals('bar', $storage->nickname);
        $this->assertEquals(true, $storage->isDirty());
    }

    /**
     * @test
     */
    public function testGetNotExistingProperty()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $value = $storage->firstname;
        $this->assertEquals(null, $value);
    }

    /**
     * @test
     */
    public function testGetData()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $data = $storage->getData();
        $this->assertEquals(['nickname' => 'foo'], $data);
    }

    /**
     * @test
     */
    public function testGetChanges()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $changes = $storage->getChanges();
        $this->assertEquals([], $changes);

        $storage->nickname = 'bar';
        $changes = $storage->getChanges();
        $this->assertEquals(['nickname' => 'bar'], $changes);
    }

    /**
     * @test
     */
    public function testGetValue()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $data = $storage->getValue('nickname');
        $this->assertEquals('foo', $data);
    }

    /**
     * @test
     */
    public function testGetValueNotExisting()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $data = $storage->getValue('firstname');
        $this->assertEquals(null, $data);
    }

    /**
     * @test
     */
    public function testSetDirty()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $storage->nickname = 'bar';

        $changes = $storage->getChanges();
        $this->assertEquals(['nickname' => 'bar'], $changes);

        $storage->setDirty(false);
        $changes = $storage->getChanges();
        $this->assertEquals([], $changes);
    }

    /**
     * @test
     */
    public function testSleep()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $data = $storage->__sleep();
        $this->assertEquals(['data', 'dirty', 'changes'], $data);
    }

    /**
     * @test
     */
    public function testUnsetProperty()
    {
        $storage = new Record([
            'nickname' => 'foo',
        ]);

        $storage->unsetProperty('nickname');

        $this->assertEquals([], $storage->getData());
    }
}
