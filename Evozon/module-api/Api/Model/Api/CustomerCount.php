<?php declare(strict_types=1);

namespace Evozon\Api\Model\Api;

use Evozon\Api\Api\Data\CustomerCountInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

use Evozon\Api\Api\Data\CustomerCountInterfaceFactory;

class CustomerCount
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $customerCollectionFactory;

    private $countInterfaceFactory;

    public function __construct(CollectionFactory $collectionFactory, CustomerCountInterfaceFactory $countInterfaceFactory)
    {
        $this->customerCollectionFactory = $collectionFactory;
        $this->countInterfaceFactory = $countInterfaceFactory;
    }

    public function getCustomerCount()
    {
        $collection = $this->customerCollectionFactory->create();
//        $response = [
//            'customer_count' => $collection->count()
//        ];
//        return (json_encode($response));
        /** @var CustomerCountInterface $val */
        $val = $this->countInterfaceFactory->create();
        $val->setCustomerCount($collection->count());
        return $val;
        // todo return a proper JSON
    }
}
