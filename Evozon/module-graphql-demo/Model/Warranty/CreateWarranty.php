<?php declare(strict_types=1);
/**
 * This file was created to persist the new warranty provider
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\Warranty;

use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterface;
use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterfaceFactory;
use Evozon\GraphQlDemo\Api\WarrantyRepositoryInterface;
use Evozon\GraphQlDemo\Model\ResourceModel\WarrantyCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;

class CreateWarranty
{
    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;
    /**
     * @var WarrantyProviderInterfaceFactory
     */
    private WarrantyProviderInterfaceFactory $warrantyFactory;
    /**
     * @var DataObjectProcessor
     */
    private DataObjectProcessor $dataObjectProcessor;
    /**
     * @var WarrantyRepositoryInterface
     */
    private WarrantyRepositoryInterface $warrantyRepository;
    /**
     * @var WarrantyCollectionFactory
     */
    private WarrantyCollectionFactory $warrantyCollectionFactory;


    /**
     * CreateWarranty constructor.
     */
    public function __construct(
        DataObjectHelper $dataObjectHelper,
        WarrantyProviderInterfaceFactory $warrantyFactory,
        DataObjectProcessor $dataObjectProcessor,
        WarrantyRepositoryInterface $warrantyRepository,
        WarrantyCollectionFactory $warrantyCollectionFactory
    ) {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->warrantyFactory = $warrantyFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->warrantyRepository = $warrantyRepository;
        $this->warrantyCollectionFactory = $warrantyCollectionFactory;
    }

    /**
     * Adds the warranty provider data to the database using the repository, then returns the newly inserted object
     * using a collection
     *
     * @param array $data
     * @return WarrantyProviderInterface
     */
    public function createWarrantyProvider(array $data) : WarrantyProviderInterface
    {
        /** @var WarrantyProviderInterface $warrantyDataObject */
        $warrantyDataObject = $this->warrantyFactory->create();

        // todo this is where we can add data validation

        // add the data to a warranty object using data object helper
        $this->dataObjectHelper->populateWithArray(
            $warrantyDataObject,
            $data,
            WarrantyProviderInterface::class
        );

        // persist the data to the database
        $this->warrantyRepository->save($warrantyDataObject);

        // retrieve the last inserted warranty using a collection (lastInsertId not working for some reason)
        $warrantyCollection = $this->warrantyCollectionFactory->create();
        $warrantyCollection->addFieldToSelect('*');
        $warrantyCollection->addOrder('entity_id', 'DESC');
        $warrantyCollection->setPageSize(1);

        /** @var WarrantyProviderInterface $newWarrantyProvider */
        $newWarrantyProvider = $warrantyCollection->getFirstItem();

        return $newWarrantyProvider;
    }

    /**
     * Creates a new warranty provider
     *
     * @param array $data
     * @return WarrantyProviderInterface
     */
    public function execute(array $data) : WarrantyProviderInterface
    {
        return $this->createWarrantyProvider($data);
    }
}
