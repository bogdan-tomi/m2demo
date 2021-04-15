<?php declare(strict_types=1);
/**
 * This file was created to
 *
 * @package     Evozon_
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Avatar extends AbstractDb
{
    private const TABLE_NAME_AVATAR_MEDIA = 'evozon_api_avatar_media';

    /**
     * Initialize the resource model with the corresponding db table
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME_AVATAR_MEDIA, 'id');
    }
}
