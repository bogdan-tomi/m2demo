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

namespace Evozon\Api\Model;

use Evozon\Api\Api\Data\AvatarInterface;
use Evozon\Api\Model\ResourceModel\Avatar as AvatarResourceModel;
use Evozon\Api\Model\ResourceModel\AvatarCollection;
use Evozon\Api\Model\ResourceModel\AvatarCollectionFactory;
use Magento\Framework\Data\Collection;
use Magento\Framework\Exception\CouldNotSaveException;

class AvatarRepository implements \Evozon\Api\Api\AvatarRepositoryInterface
{
    /**
     * @var ResourceModel\Avatar
     */
    private ResourceModel\Avatar $avatarResource;
    /**
     * @var AvatarCollectionFactory
     */
    private AvatarCollectionFactory $avatarCollectionFactory;


    /**
     * AvatarRepository constructor.
     */
    public function __construct(
        AvatarResourceModel $avatarResource,
        AvatarCollectionFactory $avatarCollectionFactory
    ) {
        $this->avatarResource = $avatarResource;
        $this->avatarCollectionFactory = $avatarCollectionFactory;
    }

    public function save(AvatarInterface $avatar): void
    {
        try {
            $this->avatarResource->save($avatar);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save avatar'), $e);
        }
    }

    public function getByCustomerId(int $customerId): AvatarInterface
    {
        /** @var AvatarCollection $avatarCollection */
        $avatarCollection = $this->avatarCollectionFactory->create();
        $avatarCollection->addFieldToFilter(Avatar::CUSTOMER_ID, $customerId);
        $avatarCollection->setOrder('id', Collection::SORT_ORDER_DESC);

        return $avatarCollection->getFirstItem();

    }
}
