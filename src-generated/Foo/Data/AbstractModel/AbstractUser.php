<?php

namespace Foo\Data\AbstractModel;

use Flex\Data\AbstractRecursiveObject;

/**
 * @author elnebuloso/flex-data (Model Generator)
 */
abstract class AbstractUser extends AbstractRecursiveObject
{

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
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


        $data = array_merge($defaults, $data);
        parent::__construct($data);
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->record->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->record->id;
    }

    /**
     * @param string $foo
     */
    public function setFoo($foo)
    {
        $this->record->foo = $foo;
    }

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->record->foo;
    }

    /**
     * @param string $bar
     */
    public function setBar($bar)
    {
        $this->record->bar = $bar;
    }

    /**
     * @return string
     */
    public function getBar()
    {
        return $this->record->bar;
    }

    /**
     * @param bool $baz
     */
    public function setBaz($baz)
    {
        $this->record->baz = $baz;
    }

    /**
     * @return bool
     */
    public function getBaz()
    {
        return $this->record->baz;
    }

    /**
     * @param bool $buz
     */
    public function setBuz($buz)
    {
        $this->record->buz = $buz;
    }

    /**
     * @return bool
     */
    public function getBuz()
    {
        return $this->record->buz;
    }

    /**
     * @param float $biz
     */
    public function setBiz($biz)
    {
        $this->record->biz = $biz;
    }

    /**
     * @return float
     */
    public function getBiz()
    {
        return $this->record->biz;
    }

    /**
     * @param null $boz
     */
    public function setBoz($boz)
    {
        $this->record->boz = $boz;
    }

    /**
     * @return null
     */
    public function getBoz()
    {
        return $this->record->boz;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->record->created_at = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->record->created_at;
    }

    /**
     * @param \DateTime $editedAt
     */
    public function setEditedAt($editedAt)
    {
        $this->record->edited_at = $editedAt;
    }

    /**
     * @return \DateTime
     */
    public function getEditedAt()
    {
        return $this->record->edited_at;
    }


}

