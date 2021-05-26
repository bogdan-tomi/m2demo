<?php declare(strict_types=1);
/**
 * This file represents the Service implementation for the new createInvitation GraphQL mutation
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Invitation\Model\Resolver;

use Evozon\Invitation\Model\Invitation\CreateInvitation as CreateInvitationModel;
use Evozon\Invitation\Model\Invitation\ExtractInvitationData;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Invitation\Model\Invitation;
use Psr\Log\LoggerInterface;

class CreateInvitation implements ResolverInterface
{
    private CreateInvitationModel $createInvitationModel;
    /**
     * @var ExtractInvitationData
     */
    private ExtractInvitationData $extractInvitationData;
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    const INVITATION_CUSTOMER_ID = 'customer_id';

    const INVITATION_GROUP_ID = 'group_id';

    /**
     * CreateInvitation constructor
     */
    public function __construct(
        CreateInvitationModel $createInvitation,
        ExtractInvitationData $extractInvitationData,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->createInvitationModel = $createInvitation;
        $this->extractInvitationData = $extractInvitationData;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Resolves adding a new invitation
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlAuthorizationException
     * @throws GraphQlInputException
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        // check if the customer is logged in
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }

        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        $data = $args['input'];

        // manually set the customer ID on the input data to be used by the create model
        $data[self::INVITATION_CUSTOMER_ID] = $context->getUserId();

        /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
        $customer = $this->customerRepository->getById((int) $context->getUserId());

        // manually set the customer group ID on the input data to be used by the create model
        $data[self::INVITATION_GROUP_ID] = $customer->getGroupId();

        try {
            // create the invitation using GraphQL input data
            /** @var Invitation $invitation */
            $invitation = $this->createInvitationModel->execute($data);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        // return the warranty data as array, keys should match the ones defined in schema.graphqls,
        // aka 'invitation' matches the createInvitationOutput one and the extracted data keys should match Invitation
        return ['invitation' => $this->extractInvitationData->execute($invitation)];
    }

}
