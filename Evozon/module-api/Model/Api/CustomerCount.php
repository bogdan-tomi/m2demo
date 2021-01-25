<?php declare(strict_types=1);

namespace Evozon\Api\Model\Api;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Evozon\Api\Api\Data\CounterInterface;
use Evozon\Api\Api\Data\CounterInterfaceFactory;

class CustomerCount
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $customerCollectionFactory;

    private CounterInterfaceFactory $counterFactory;

    public function __construct(CollectionFactory $collectionFactory, CounterInterfaceFactory $countInterfaceFactory)
    {
        $this->customerCollectionFactory = $collectionFactory;
        $this->counterFactory = $countInterfaceFactory;
    }

    public function getCustomerCount()
    {
        $collection = $this->customerCollectionFactory->create();
        /** @var CounterInterface $customerCounter */
        $customerCounter = $this->counterFactory->create();
        $customerCounter->setCustomerCount($collection->count());
        return $customerCounter;
    }
}
