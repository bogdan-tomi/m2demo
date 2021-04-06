<?php declare(strict_types=1);
/**
 * This file was created to serve the implementation of sending a custom email template for a given order id
 *
 * @package     Evozon_Api
 * @subpackage  Model
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class SendOrderCompleteEmail implements \Evozon\Api\Model\SendOrderCompleteEmailInterface
{
    /**
     * @var TransportBuilder
     */
    private TransportBuilder $transportBuilder;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * SendOrderCompleteEmail constructor.
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        LoggerInterface $logger,
        OrderRepositoryInterface $orderRepository,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute($orderId): bool
    {
        if (!$orderId) {
            return false;
        }

        // retrieve the order by id
        $order = $this->orderRepository->get($orderId);

        // exit if the order state is not complete
        if ($order->getState() !== \Magento\Sales\Model\Order::STATE_COMPLETE) {
            return false;
        }

        $transport = $this->transportBuilder->setTemplateIdentifier(
            // we need to retrieve the value from the hidden configuration field
            $this->scopeConfig->getValue(
                self::XML_PATH_COMPLETE_ORDER_EMAIL_FIELD
            )
        )
            //todo add template vars from request
            ->setTemplateVars([])
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $order->getStoreId()
                ]
            )
            // retrieve the customer email from the order
            ->addTo($order->getCustomerEmail())
            ->getTransport();

        try {
            $transport->sendMessage();
        } catch (\Magento\Framework\Exception\MailException $e) {
            $this->logger->critical($e);
            return false;
        }

        return true;
    }
}
