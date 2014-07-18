<?php
namespace Flex\Data;

/**
 * Class ToJsonInterface
 *
 * @package Flex\Data
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
interface ToJsonInterface {

    /**
     * @return array
     */
    public function toJson();
}