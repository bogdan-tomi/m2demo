<?php declare(strict_types=1);
/**
 * This file was created to
 *
 * @package     Evozon_
 * @subpackage
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

        $order = $this->orderRepository->get($orderId);

        if ($order->getState() !== \Magento\Sales\Model\Order::STATE_COMPLETE) {
            return false;
        }

        $transport = $this->transportBuilder->setTemplateIdentifier(
            // we need to retrieve the value from the hidden configuration field
            $this->scopeConfig->getValue(
                self::XML_PATH_COMPLETE_ORDER_EMAIL_FIELD
            )
        )
            ->setTemplateVars([])
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $order->getStoreId()
                ]
            )
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
