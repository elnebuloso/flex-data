<?php

namespace Foo\Data\AbstractModel\User\Payment;

use Flex\Data\AbstractRecursiveObject;

/**
 * @author elnebuloso/flex-data
 */
abstract class AbstractTransaction extends AbstractRecursiveObject
{

    /**
     * @return array
     */
    public function getRecordDefaults()
    {
        $defaults = array (
          'id' => 123,
          'foo' => 'defaultFoo',
          'bar' => 'defaultBar',
          'baz' => true,
          'buz' => false,
          'biz' => 1.234,
          'boz' => NULL,
          'created_at' => NULL,
          'edited_at' => NULL,
        );

        $defaults['created_at'] = new \DateTime('2014-10-23 00:00:00');

        return $defaults;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->setRecordValue('id', $id);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getRecordValue('id');
    }

    /**
     * @param string $foo
     */
    public function setFoo($foo)
    {
        $this->setRecordValue('foo', $foo);
    }

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->getRecordValue('foo');
    }

    /**
     * @param string $bar
     */
    public function setBar($bar)
    {
        $this->setRecordValue('bar', $bar);
    }

    /**
     * @return string
     */
    public function getBar()
    {
        return $this->getRecordValue('bar');
    }

    /**
     * @param bool $baz
     */
    public function setBaz($baz)
    {
        $this->setRecordValue('baz', $baz);
    }

    /**
     * @return bool
     */
    public function getBaz()
    {
        return $this->getRecordValue('baz');
    }

    /**
     * @param bool $buz
     */
    public function setBuz($buz)
    {
        $this->setRecordValue('buz', $buz);
    }

    /**
     * @return bool
     */
    public function getBuz()
    {
        return $this->getRecordValue('buz');
    }

    /**
     * @param float $biz
     */
    public function setBiz($biz)
    {
        $this->setRecordValue('biz', $biz);
    }

    /**
     * @return float
     */
    public function getBiz()
    {
        return $this->getRecordValue('biz');
    }

    /**
     * @param null $boz
     */
    public function setBoz($boz)
    {
        $this->setRecordValue('boz', $boz);
    }

    /**
     * @return null
     */
    public function getBoz()
    {
        return $this->getRecordValue('boz');
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->setRecordValue('created_at', $createdAt);
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->getRecordValue('created_at');
    }

    /**
     * @param \DateTime $editedAt
     */
    public function setEditedAt(\DateTime $editedAt)
    {
        $this->setRecordValue('edited_at', $editedAt);
    }

    /**
     * @return \DateTime
     */
    public function getEditedAt()
    {
        return $this->getRecordValue('edited_at');
    }


}

