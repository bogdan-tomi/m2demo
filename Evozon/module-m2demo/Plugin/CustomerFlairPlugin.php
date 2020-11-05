<?php


namespace Evozon\M2Demo\Plugin;


use Evozon\M2Demo\Model\CustomerFlairRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

class CustomerFlairPlugin
{
    /**
     * @var CustomerFlairRepository
     */
    private CustomerFlairRepository $customerFlairRepository;

    public function __construct(CustomerFlairRepository $customerFlairRepository)
    {
        $this->customerFlairRepository = $customerFlairRepository;
    }

    public function afterGet(CustomerRepositoryInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $this->populateCustomerFlairExtAttr((int) $result->getId(), $result->getExtensionAttributes());
        return $result;
    }

    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $this->populateCustomerFlairExtAttr((int) $result->getId(), $result->getExtensionAttributes());
        return $result;
    }

    private function populateCustomerFlairExtAttr(
        int $customerId,
        CustomerExtensionInterface $customerExtensionAttributes
    ): void {
        if ($customerExtensionAttributes->getEvozonM2demoCustomerFlair()) {
            return;
        }
        try {
            $customerFlair = $this->customerFlairRepository->getByCustomerId($customerId);
            $customerExtensionAttributes->setEvozonM2demoCustomerFlair($customerFlair);
        } catch (NoSuchEntityException $exception) {
            //empty on purpose
        }
    }

    /**
     * @throws AlreadyExistsException
     */
    public function aroundSave(
        CustomerRepositoryInterface $subject,
        callable $proceed,
        CustomerInterface $customer,
        $passwordHash = null
    ): CustomerInterface {
        $customerFlair = $customer->getExtensionAttributes()->getEvozonM2demoCustomerFlair();

        /** @var CustomerInterface $result */
        $result = $proceed($customer, $passwordHash);

        if ($customerFlair) {
            $this->customerFlairRepository->setForCustomerId((int) $result->getId(), $customerFlair);
        } else {
            $this->customerFlairRepository->deleteForCustomerId((int) $result->getId());
        }
        return $result;
    }

    public function afterGetList(
        CustomerRepositoryInterface $subject,
        CustomerSearchResultsInterface $result
    ): CustomerSearchResultsInterface {
        /** @var CustomerInterface[] $customers */
        $customers = array_reduce($result->getItems(), function (array $map, CustomerInterface $customer): array {
            $customerId = $customer->getId();
            $map[(int) $customerId] = $customer;
            return $map;
        }, []);

        // aka
//        foreach ($result->getItems() as $customer) {
//            $customers[(int) $customer->getId()] = $customer;
//        }

        // getForCustomerIds expects any number of ints, not an array of ints
        $customerFlairs = $this->customerFlairRepository->getForCustomerIds(...array_keys($customers));

        foreach ($customerFlairs as $customerFlair) {
            $customerId = $customerFlair->getCustomerId();
            $customers[$customerId]->getExtensionAttributes()->setEvozonM2demoCustomerFlair($customerFlair);
        }

        return $result;
    }
}
