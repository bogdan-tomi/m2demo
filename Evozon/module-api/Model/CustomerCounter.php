<?php declare(strict_types=1);

namespace Evozon\Api\Model;

use Evozon\Api\Api\Data\CounterInterface;

class CustomerCounter implements CounterInterface
{
    private int $customerCount;

    public function getCustomerCount()
    {
        return $this->customerCount;
    }

    public function setCustomerCount($value)
    {
        $this->customerCount = (int) $value;
    }
}
