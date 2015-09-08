<?php
namespace FlexTest\Data\AbstractObjectTest;

use Flex\Data\AbstractObject;

/**
 * Class User
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class User extends AbstractObject
{
    /**
     * @return string
     */
    public function getName()
    {
        return $this->record->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->record->name = $name;
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->record->user = $user;
    }
}
