<?php
namespace FlexTest\Data\AbstractRecursiveObjectTest;

use Flex\Data\AbstractRecursiveObject;

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
