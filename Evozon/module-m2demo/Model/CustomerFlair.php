<?php declare(strict_types=1);

namespace Evozon\M2Demo\Model;

use Evozon\M2Demo\Model\Api\Data\CustomerFlairExtensionInterface;
use Evozon\M2Demo\Model\Api\Data\CustomerFlairInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Evozon\M2Demo\Model\ResourceModel\CustomerFlair as CustomerFlairResource;

class CustomerFlair extends AbstractExtensibleModel implements CustomerFlairInterface
{
    protected function _construct()
    {
        // declare the customer resource class for the model
        $this->_init(CustomerFlairResource::class);
    }

    public function getNickname(): ?string
    {
        return $this->_getData('nickname');
    }

    public function setNickname(?string $nickname): void
    {
        $this->setData('nickname', $nickname);
    }

    public function getCustomerId(): ?int
    {
        $customerId = $this->_getData('customer_id');
        return ($customerId) ? (int) $customerId : null;
    }

    public function setCustomerId($customerId): void
    {
        $this->setData('customer_id', $customerId);
    }

    public function getMotto(): ?string
    {
        return $this->_getData('motto');
    }

    public function setMotto(?string $motto): void
    {
        $this->setData('motto', $motto);
    }

    public function setExtensionAttributes(CustomerFlairExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }
}
