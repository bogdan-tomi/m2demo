<?php declare(strict_types=1);
/**
 * This file was created to extract the data from the warranty object to a suitable array for GraphQL
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\Warranty;

use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Webapi\ServiceOutputProcessor;

class ExtractWarrantyData
{
    /**
     * @var DataObjectProcessor
     */
    private DataObjectProcessor $dataObjectProcessor;

    /**
     * ExtractWarrantyData constructor.
     * @param ServiceOutputProcessor $serviceOutputProcessor
     */
    public function __construct(DataObjectProcessor $dataObjectProcessor)
    {
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Extract the warranty object data as an array
     *
     * @param WarrantyProviderInterface $warrantyProvider
     * @return array
     */
    public function execute(WarrantyProviderInterface $warrantyProvider) : array
    {
        //todo this is where the object data could be manipulated further to be returned as an array for GraphQL

        $warrantyProviderData = $this->dataObjectProcessor->buildOutputDataArray(
            $warrantyProvider,
            WarrantyProviderInterface::class
        );

        return $warrantyProviderData;
    }
}
