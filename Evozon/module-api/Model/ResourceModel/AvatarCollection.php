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

use Evozon\Api\Model\Avatar as AvatarModel;
use Evozon\Api\Model\ResourceModel\Avatar as AvatarResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class AvatarCollection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(AvatarModel::class, AvatarResourceModel::class);
    }
}
