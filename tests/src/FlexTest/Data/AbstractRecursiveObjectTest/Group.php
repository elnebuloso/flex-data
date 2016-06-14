<?php
namespace elnebuloso\FlexTest\Data\AbstractRecursiveObjectTest;

use elnebuloso\Flex\Data\AbstractRecursiveObject;

class Group extends AbstractRecursiveObject
{
    /**
     * @return array
     */
    public function getRecordDefaults()
    {
        return [
            'name' => 'group1',
        ];
    }
}
