<?php declare(strict_types=1);
/**
 * This file was created to serve as a repository for the warranty providers
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model;

use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterface;
use Evozon\GraphQlDemo\Api\WarrantyRepositoryInterface;
use Evozon\GraphQlDemo\Model\ResourceModel\WarrantyCollection;
use Evozon\GraphQlDemo\Model\ResourceModel\WarrantyCollectionFactory;
use Evozon\GraphQlDemo\Model\ResourceModel\WarrantyProvider as WarrantyProviderResourceModel;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;

class WarrantyProviderRepository implements WarrantyRepositoryInterface
{
    /**
     * @var WarrantyCollectionFactory
     */
    private WarrantyCollectionFactory $warrantyCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $warrantySearchResultsInterfaceFactory;
    /**
     * @var WarrantyProviderResourceModel
     */
    private WarrantyProviderResourceModel $warrantyResourceModel;


    /**
     * WarrantyProviderRepository constructor.
     */
    public function __construct(
        WarrantyCollectionFactory $warrantyCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SearchResultsInterfaceFactory $warrantySearchResultsInterfaceFactory,
        WarrantyProviderResourceModel $warrantyProviderResourceModel
    )
    {
        $this->warrantyCollectionFactory = $warrantyCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->warrantySearchResultsInterfaceFactory = $warrantySearchResultsInterfaceFactory;
        $this->warrantyResourceModel = $warrantyProviderResourceModel;
    }

    /**
     * Finds warranty providers by the given criteria, using the warranty collection
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        /** @var WarrantyCollection $warrantyCollection */
        $warrantyCollection = $this->warrantyCollectionFactory->create();
        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $warrantyCollection);
        }
        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->warrantySearchResultsInterfaceFactory->create();
        $searchResult->setItems($warrantyCollection->getItems());
        $searchResult->setTotalCount($warrantyCollection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    /**
     * Saves the warranty provider data
     *
     * @param WarrantyProviderInterface $warrantyProvider
     * @throws CouldNotSaveException
     */
    public function save(WarrantyProviderInterface $warrantyProvider): void
    {
        try {
            $this->warrantyResourceModel->save($warrantyProvider);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save warranty provider'), $e);
        }
    }

}
