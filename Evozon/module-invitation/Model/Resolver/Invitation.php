<?php declare(strict_types=1);
/**
 * This file represents the Service implementation for the new invitation GraphQL query
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Invitation\Model\Resolver;

use Evozon\Invitation\Model\InvitationRepository;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\ArgumentApplier\Filter;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Invitation implements ResolverInterface
{
    /**
     * @var InvitationRepository
     */
    private InvitationRepository $invitationRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Invitation constructor
     */
    public function __construct(
        InvitationRepository $invitationRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->invitationRepository = $invitationRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * --description
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlAuthorizationException
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        // check if the customer is logged in
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }

        // add the customer id as a filter
        $args[Filter::ARGUMENT_NAME]['customer_id']['eq'] = $context->getUserId();

        $searchCriteria = $this->searchCriteriaBuilder->build('invitation', $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);

        $searchResult = $this->invitationRepository->getList($searchCriteria);

        return [
            'total_count' => $searchResult->getTotalCount(),
            'items' => $searchResult->getItems()
        ];

    }
}
