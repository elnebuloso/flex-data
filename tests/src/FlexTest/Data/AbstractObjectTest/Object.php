<?php
namespace FlexTest\Data\AbstractObjectTest;

use Flex\Data\AbstractObject;

/**
 * Class Object
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class Object extends AbstractObject
{
    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->record->nickname;
    }

    /**
     * @param string $v
     */
    public function setNickname($v)
    {
        $this->record->nickname = $v;
    }
}
