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
     * @return void
     */
    public function test_constructor_emptyData() {
        $storage = new Record();
        $storage->nickname = 'foo';

        $this->assertEquals('foo', $storage->nickname);
    }

    /**
     * @return void
     */
    public function test_constructor_withData() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $this->assertEquals('foo', $storage->nickname);
    }

    /**
     * @return void
     */
    public function test_constructor_emptyDataDirty() {
        $storage = new Record();
        $this->assertEquals(false, $storage->isDirty());
    }

    /**
     * @return void
     */
    public function test_constructor_withDataDirty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $this->assertEquals(false, $storage->isDirty());
    }

    /**
     * @return void
     */
    public function test_isDirty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $this->assertEquals(false, $storage->isDirty());
        $storage->nickname = 'bar';
        $this->assertEquals('bar', $storage->nickname);
        $this->assertEquals(true, $storage->isDirty());
    }

    /**
     * @return void
     */
    public function test_getNotExistingProperty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $value = $storage->firstname;
        $this->assertEquals(null, $value);
    }

    /**
     * @return void
     */
    public function test_getData() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $data = $storage->getData();
        $this->assertEquals(array(
            'nickname' => 'foo'
        ), $data);
    }

    /**
     * @return void
     */
    public function test_getChanges() {
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
     * @return void
     */
    public function test_getValue() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $data = $storage->getValue('nickname');
        $this->assertEquals('foo', $data);
    }

    /**
     * @return void
     */
    public function test_getValue_notExisting() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $data = $storage->getValue('firstname');
        $this->assertEquals(null, $data);
    }

    /**
     * @return void
     */
    public function test_setDirty() {
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
     * @return void
     */
    public function test_sleep() {
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
     * @return void
     */
    public function test_unsetProperty() {
        $storage = new Record(array(
            'nickname' => 'foo'
        ));

        $storage->unsetProperty('nickname');

        $this->assertEquals(array(), $storage->getData());
    }
}