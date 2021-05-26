<?php
/**
 * This interface was created to provide decoupling for the invitation repository implementation
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Invitation\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Invitation\Model\Invitation;

interface InvitationInterface
{
    /**
     * Finds invitation by the given criteria for the current customer
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultsInterface
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface;

    /**
     * Adds a new invitation for the current customer with the given data
     *
     * @param Invitation $invitation
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function save(Invitation $invitation): void;
}
