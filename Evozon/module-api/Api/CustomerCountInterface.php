<?php declare(strict_types=1);


namespace Evozon\Api\Api;


interface CustomerCountInterface
{
    /**
     * docblock return type required for reflection
     *
     * @return Evozon\Api\Api\Data\CounterInterface
     */
    public function getCustomerCount();
}
