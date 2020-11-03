<?php declare(strict_types=1);

namespace Evozon\M2Demo\Model\ResourceModel\CustomerFlair;

use Evozon\M2Demo\Model\CustomerFlair;
use Evozon\M2Demo\Model\ResourceModel\CustomerFlair as CustomerFlairResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        // declare the model and resource model classes for the collection
        $this->_init(CustomerFlair::class, CustomerFlairResource::class);
    }
}
