<?php
/**
 * This interface was created to provide decoupling for the warranty provider repository implementation
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Api;

use Evozon\GraphQlDemo\Api\Data\WarrantyProviderInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface WarrantyRepositoryInterface
{
    /**
     * Saves the warranty provider data
     *
     * @param WarrantyProviderInterface $warrantyProvider
     * @return void
     */
    public function save(WarrantyProviderInterface $warrantyProvider): void;

    /**
     * Finds warranty providers by the given criteria
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface;
}
