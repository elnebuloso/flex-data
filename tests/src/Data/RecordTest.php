<?php
namespace FlexTest\Data;

use Flex\Data\Record;

/**
 * Class RecordTest
 *
 * @package FlexTest\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class RecordTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function constructorEmptyData() {
        $storage = new Record();
        $storage->nickname = 'foo';

        $this->assertEquals('foo', $storage->nickname);
    }

    /**
     * @test
     */
    public function constructorWithData() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $this->assertEquals('foo', $storage->nickname);
    }

    /**
     * @test
     */
    public function constructorEmptyDataDirty() {
        $storage = new Record();
        $this->assertEquals(false, $storage->isDirty());
    }

    /**
     * @test
     */
    public function constructorWithDataDirty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $this->assertEquals(false, $storage->isDirty());
    }

    /**
     * @test
     */
    public function isDirty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $this->assertEquals(false, $storage->isDirty());
        $storage->nickname = 'bar';
        $this->assertEquals('bar', $storage->nickname);
        $this->assertEquals(true, $storage->isDirty());
    }

    /**
     * @test
     */
    public function getNotExistingProperty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $value = $storage->firstname;
        $this->assertEquals(null, $value);
    }

    /**
     * @test
     */
    public function getData() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $data = $storage->getData();
        $this->assertEquals(array(
            'nickname' => 'foo'
        ), $data);
    }

    /**
     * @test
     */
    public function getChanges() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $changes = $storage->getChanges();
        $this->assertEquals(array(), $changes);

        $storage->nickname = 'bar';
        $changes = $storage->getChanges();
        $this->assertEquals(array(
            'nickname' => 'bar'
        ), $changes);
    }

    /**
     * @test
     */
    public function getValue() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $data = $storage->getValue('nickname');
        $this->assertEquals('foo', $data);
    }

    /**
     * @test
     */
    public function getValueNotExisting() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $data = $storage->getValue('firstname');
        $this->assertEquals(null, $data);
    }

    /**
     * @test
     */
    public function setDirty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $storage->nickname = 'bar';

        $changes = $storage->getChanges();
        $this->assertEquals(array(
            'nickname' => 'bar'
        ), $changes);

        $storage->setDirty(false);
        $changes = $storage->getChanges();
        $this->assertEquals(array(), $changes);
    }

    /**
     * @test
     */
    public function sleep() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $data = $storage->__sleep();
        $this->assertEquals(array(
            'data',
            'dirty',
            'changes'
        ), $data);
    }

    /**
     * @test
     */
    public function unsetProperty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $storage->unsetProperty('nickname');

        $this->assertEquals(array(), $storage->getData());
    }
}