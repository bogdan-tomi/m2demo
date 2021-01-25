<?php


namespace Evozon\Api\Api\Data;


interface CustomerCountInterface
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
