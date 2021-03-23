<?php declare(strict_types=1);
/**
 * This file was created to represent the warranty providers collection
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Evozon\GraphQlDemo\Model\WarrantyProvider as WarrantyModel;
use Evozon\GraphQlDemo\Model\ResourceModel\WarrantyProvider as WarrantyResourceModel;

class WarrantyCollection extends AbstractCollection
{
    /**
     * Initialize the collection with the corresponding model and resource model
     */
    protected function _construct()
    {
        $this->_init(WarrantyModel::class, WarrantyResourceModel::class);
    }
}
