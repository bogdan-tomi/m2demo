<?php declare(strict_types=1);
/**
 * This file was created to serve as a repository for the invitations
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Invitation\Model;

use Evozon\Invitation\Api\InvitationInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Invitation\Model\Invitation;
use Magento\Invitation\Model\ResourceModel\Invitation as InvitationResourceModel;
use Magento\Invitation\Model\ResourceModel\Invitation\Collection;
use Magento\Invitation\Model\ResourceModel\Invitation\CollectionFactory;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;


class InvitationRepository implements InvitationInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $invitationCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $searchResultsFactory;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var InvitationResourceModel
     */
    private InvitationResourceModel $invitationResourceModel;

    /**
     * InvitationRepository constructor
     */
    public function __construct(
        CollectionFactory $invitationCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        InvitationResourceModel $invitationResourceModel
    ) {
        $this->invitationCollectionFactory = $invitationCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->invitationResourceModel = $invitationResourceModel;
    }

    /**
     * Finds and returns invitations by the given criteria, using the invitation collection
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultsInterface
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        /** @var Collection $invitationCollection */
        $invitationCollection = $this->invitationCollectionFactory->create();

        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $invitationCollection);
        }

        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($invitationCollection->getItems());
        $searchResult->setTotalCount($invitationCollection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    /**
     *
     *
     * @param Invitation $invitation
     * @throws AlreadyExistsException
     * @throws CouldNotSaveException
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function save(Invitation $invitation): void
    {
        try {
            $this->invitationResourceModel->save($invitation);
        } catch (AlreadyExistsException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save invitation'), $e);
        }
    }


}
