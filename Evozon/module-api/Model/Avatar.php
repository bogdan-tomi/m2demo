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

use Magento\Framework\Model\AbstractExtensibleModel;

class Avatar extends AbstractExtensibleModel implements \Evozon\Api\Api\Data\AvatarInterface
{

    /**
     * Initialize the model with the corresponding resource model
     */
    protected function _construct()
    {
        $this->_init(\Evozon\Api\Model\ResourceModel\Avatar::class);
    }

    /**
     * @inheritDoc
     */
    public function getValue(): ?string
    {
        return $this->getData(self::VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setValue(?string $value): void
    {
        $this->setData(self::VALUE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId(): ?int
    {
        return (int) $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId(?int $customerId): void
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
