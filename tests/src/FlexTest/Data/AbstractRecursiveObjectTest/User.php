<?php
namespace FlexTest\Data\AbstractRecursiveObjectTest;

use Flex\Data\AbstractRecursiveObject;

/**
 * Class User
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class User extends AbstractRecursiveObject
{
    /**
     * @return array
     */
    public function getRecordDefaults()
    {
        return [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'group' => new Group(),
            'location' => [
                'city' => 'Berlin',
                'geo' => [
                    'lat' => '51.0000',
                    'lon' => '8.0000',
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->getRecordValue('firstname');
    }

    /**
     * @return array
     */
    public function getLocation()
    {
        return $this->getRecordValue('location');
    }

    /**
     * @return string
     */
    public function getLocationCity()
    {
        return $this->getRecordValue('location/city');
    }

    /**
     * @return string
     */
    public function getLocationGeoLat()
    {
        return $this->getRecordValue('location/geo/lat');
    }
}
