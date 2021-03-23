<?php declare(strict_types=1);
/**
 * This file was created to represent the warranty provider resource model
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class WarrantyProvider extends AbstractDb
{
    private const TABLE_NAME_WARRANTY = 'evozon_graphql_demo_warranty_provider';

    /**
     * Initialize the resource model with the corresponding db table
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME_WARRANTY, 'entity_id');
    }
}
