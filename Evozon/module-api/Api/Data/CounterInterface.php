<?php


namespace Evozon\Api\Api\Data;


interface CounterInterface
{
    /**
     * @return int
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function getCustomerCount();

    /**
     * @param $value string
     * @return null
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function setCustomerCount($value);
}
