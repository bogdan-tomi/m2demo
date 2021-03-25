<?php declare(strict_types=1);
/**
 * This file was created to resolve a custom copy of the Customer GraphQL query
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\Resolver;

use Magento\CustomerGraphQl\Model\Customer\ExtractCustomerData;
use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Psr\Log\LoggerInterface;

class Customer implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    /**
     * @var GetCustomer
     */
    private GetCustomer $getCustomer;
    /**
     * @var ExtractCustomerData
     */
    private ExtractCustomerData $extractCustomerData;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Customer constructor.
     */
    public function __construct(
        GetCustomer $getCustomer,
        ExtractCustomerData $extractCustomerData,
        LoggerInterface $logger
    ) {
        $this->getCustomer = $getCustomer;
        $this->extractCustomerData = $extractCustomerData;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        //TODO
        // the token set in the request header under Authorization => Bearer {Token} is checked in the
        // \Magento\Webapi\Model\Authorization\TokenUserContext::processRequest() method
        // (compared against the token saved along with the customer_id in the oauth_token db table, during the
        // generateCustomerToken mutation),
        // all due to the fact that a context is created via factory in the \Magento\GraphQl\Controller\GraphQl::dispatch() method,
        // which initializes the \Magento\Webapi\Model\Authorization\TokenUserContext context used by GraphQL requests.

        // todo so this is the check used by Magento to validate the current auth token
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }

        $customer = $this->getCustomer->execute($context);
        return $this->extractCustomerData->execute($customer);
    }
}
