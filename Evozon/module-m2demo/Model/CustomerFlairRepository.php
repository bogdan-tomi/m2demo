<?php

namespace Evozon\M2Demo\Model;

use Evozon\M2Demo\Model\Api\Data\CustomerFlairInterface;
use Evozon\M2Demo\Model\ResourceModel\CustomerFlair as CustomerFlairResource;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface as ExtensionAttributesJoinProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class CustomerFlairRepository
{
    /**
     * @var CustomerFlairFactory
     */
    private CustomerFlairFactory $customerFlairFactory;
    /**
     * @var CustomerFlairResource
     */
    private CustomerFlairResource $customerFlairResource;
    /**
     * @var CustomerFlairResource\CollectionFactory
     */
    private CustomerFlairResource\CollectionFactory $collectionFactory;
    /**
     * @var DataObjectProcessor
     */
    private DataObjectProcessor $dataObjProcessor;
    /**
     * @var Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    private ExtensionAttributesJoinProcessorInterface $extensionAttributesJoinProcessor;

    public function __construct(
        CustomerFlairFactory $customerFlairFactory,
        CustomerFlairResource $customerFlairResource,
        CustomerFlairResource\CollectionFactory $collectionFactory,
        DataObjectProcessor $dataObjectProcessor,
        ExtensionAttributesJoinProcessorInterface $extensionAttributesJoinProcessor
    ) {
        $this->customerFlairFactory = $customerFlairFactory;
        $this->customerFlairResource = $customerFlairResource;
        $this->collectionFactory = $collectionFactory;
        $this->dataObjProcessor = $dataObjectProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getByCustomerId(int $customerId): CustomerFlairInterface
    {
        $customerCollection = $this->collectionFactory->create();
        $customerCollection->addFieldToFilter('customer_id', $customerId);
        $this->extensionAttributesJoinProcessor->process($customerCollection);
        if ($customerCollection->count() > 0) {
            /** @var CustomerFlair $customer */
            $customer = $customerCollection->getFirstItem();
            return $customer;
        }
        throw new NoSuchEntityException();
    }

    public function deleteForCustomerId(int $customerId): void
    {
        $customerCollection = $this->collectionFactory->create();
        $customerCollection->addFieldToFilter('customer_id', $customerId);
        $customerCollection->walk('delete');
    }

    private function convertDtoToModel(CustomerFlairInterface $customerFlairDto): CustomerFlair
    {
        $data = $this->dataObjProcessor->buildOutputDataArray($customerFlairDto, CustomerFlairInterface::class);
        $customerModel = $this->customerFlairFactory->create();
        $customerModel->setData($data);

        return $customerModel;
    }

    private function ensureIsModel(CustomerFlairInterface $customerFlairDto): CustomerFlair
    {
        return $customerFlairDto instanceof CustomerFlair ?
            $customerFlairDto :
            $this->convertDtoToModel($customerFlairDto);
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function setForCustomerId(int $customerId, CustomerFlairInterface $customerFlair): void
    {
        try {
            $existingCustomerFlair = $this->getByCustomerId($customerId);
            if ($existingCustomerFlair->getId() != $customerFlair->getId()) {
                $this->customerFlairResource->delete($this->ensureIsModel($existingCustomerFlair));
            }
        } catch (NoSuchEntityException $exception) {
            // nothing to delete if there is no existing record
        }
        $customerFlair->setCustomerId($customerId);
        $this->customerFlairResource->save($this->ensureIsModel($customerFlair));
    }

    /**
     * @return CustomerFlairInterface[]
     */
    public function getForCustomerIds(int ...$customerIds): array
    {
        $customerCollection = $this->collectionFactory->create();
        $customerCollection->addFieldToFilter('customer_id', ['in' => $customerIds]);
        $this->extensionAttributesJoinProcessor->process($customerCollection);
        return $customerCollection->getItems();
    }
}
