<?php declare(strict_types=1);

namespace Evozon\M2Demo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerFlair extends AbstractDb
{
    protected function _construct()
    {
        // declare the table, and the primary key for the resource model
        $this->_init('evozon_m2demo_customer_flair', 'id');
    }
}
