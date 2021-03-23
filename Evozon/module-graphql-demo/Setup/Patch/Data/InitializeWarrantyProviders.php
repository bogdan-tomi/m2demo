<?php declare(strict_types=1);
/**
 * This data patch was created to provide sample data for warranty providers
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Setup\Patch\Data;

use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterface as WarrantyInterface;
use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterfaceFactory;
use Evozon\GraphQlDemo\Api\WarrantyRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InitializeWarrantyProviders implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;
    /**
     * @var WarrantyProviderInterfaceFactory
     */
    private WarrantyProviderInterfaceFactory $warrantyInterfaceFactory;
    /**
     * @var WarrantyRepositoryInterface
     */
    private WarrantyRepositoryInterface $warrantyRepository;
    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * InitializeWarrantyProviders constructor.
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WarrantyProviderInterfaceFactory $warrantyInterfaceFactory,
        WarrantyRepositoryInterface $warrantyRepository,
        DataObjectHelper $dataObjectHelper
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->warrantyInterfaceFactory = $warrantyInterfaceFactory;
        $this->warrantyRepository = $warrantyRepository;
        $this->dataObjectHelper = $dataObjectHelper;
    }


    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Add sample warranty provider data
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        for ($i = 0; $i <= 9; $i++) {
            $warrantyData = [
                WarrantyInterface::NAME => 'Warranty Provider ' . $i,
                WarrantyInterface::COUNTRY => 'Country ' . $i,
                WarrantyInterface::RATING_AVERAGE => random_int(100, 10000) / 100,
                WarrantyInterface::RATING_COUNT => random_int(1, 1000)
            ];
            /** @var WarrantyInterface $warrantyProvider */
            $warrantyProvider = $this->warrantyInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($warrantyProvider, $warrantyData, WarrantyInterface::class);
            $this->warrantyRepository->save($warrantyProvider);
        }

        $this->moduleDataSetup->endSetup();
    }
}
