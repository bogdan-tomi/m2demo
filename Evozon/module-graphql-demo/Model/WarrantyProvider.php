<?php declare(strict_types=1);
/**
 * This file was created to serve as a model for warranty providers
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model;

use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterface;
use Evozon\GraphQlDemo\Model\ResourceModel\WarrantyProvider as WarrantyResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;

class WarrantyProvider extends AbstractExtensibleModel implements WarrantyProviderInterface
{
    /**
     * Initialize the model with the corresponding resource model
     */
    protected function _construct()
    {
        $this->_init(WarrantyResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @inheritdoc
     */
    public function getCountry(): ?string
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * @inheritdoc
     */
    public function setCountry(?string $country): void
    {
        $this->setData(self::COUNTRY, $country);
    }

    /**
     * @inheritdoc
     */
    public function getRatingCount(): ?int
    {
        return (int) $this->getData(self::RATING_COUNT);
    }

    /**
     * @inheritdoc
     */
    public function setRatingCount(?int $ratingCount): void
    {
        $this->setData(self::RATING_COUNT, $ratingCount);
    }

    /**
     * @inheritdoc
     */
    public function getRatingAverage(): ?float
    {
        return (float) $this->getData(self::RATING_AVERAGE);
    }

    /**
     * @inheritdoc
     */
    public function setRatingAverage(?float $ratingAverage): void
    {
        $this->setData(self::RATING_AVERAGE, $ratingAverage);
    }
}
