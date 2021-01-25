<?php declare(strict_types=1);

namespace Evozon\Api\Model\Api;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class CustomerCount
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $customerCollectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->customerCollectionFactory = $collectionFactory;
    }

    public function getCustomerCount()
    {
        $collection = $this->customerCollectionFactory->create();
        $response = [[
            'customer_count' => $collection->count()
        ]];
        return $response;
        // todo return a proper JSON
    }
}
