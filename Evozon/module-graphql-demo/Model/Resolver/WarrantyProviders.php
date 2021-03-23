<?php declare(strict_types=1);
/**
 * This file represents the Service implementation for the new warrantyProviders GraphQL query
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\Resolver;

use Evozon\GraphQlDemo\Model\WarrantyProviderRepository;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class WarrantyProviders implements ResolverInterface
{
    /**
     * @var WarrantyProviderRepository
     */
    private WarrantyProviderRepository $warrantyRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * WarrantyProviders constructor.
     */
    public function __construct(WarrantyProviderRepository $warrantyRepository, SearchCriteriaBuilder $searchCriteriaBuilder)
    {
        $this->warrantyRepository = $warrantyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Validate the optional arguments for our query
     *
     * @param array $args
     * @throws GraphQlInputException
     */
    private function validateArgs(array $args): void
    {
        if (isset($args['currentPage']) && $args['currentPage'] < 1) {
            throw new GraphQlInputException(__('currentPage value must be greater than 0'));
        }
        if (isset($args['pageSize']) && $args['pageSize'] < 1) {
            throw new GraphQlInputException(__('pageSize value must be greater than 0'));
        }
    }

    /**
     *
     *
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $this->validateArgs($args);

        // the fieldName used here needs to match the item we inject into the
        // Magento\Framework\GraphQl\Query\Resolver\Argument\FieldEntityAttributesPool constructor using di.xml
        $searchCriteria = $this->searchCriteriaBuilder->build('warranty_providers', $args);
        // note that the search criteria is not the Magento\Framework\Api\Search\SearchCriteriaBuilder one, but the
        // Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);

        // retrieve the matching warranty providers using our warranty repository
        $searchResult = $this->warrantyRepository->getList($searchCriteria);

        // the returned keys must match the ones we declared in schema.graphqls for the output (warrantyProvidersOutput)
        return [
            'total_count' => $searchResult->getTotalCount(),
            'items' => $searchResult->getItems()
        ];
    }
}
