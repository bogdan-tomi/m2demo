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

namespace Evozon\Api\Model\Api;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class SendOrderCompleteEmail implements \Evozon\Api\Api\SendOrderCompleteEmailInterface
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
     * SendOrderCompleteEmail constructor.
     */
    public function __construct(TransportBuilder $transportBuilder, LoggerInterface $logger, OrderRepositoryInterface $orderRepository)
    {
        $this->transportBuilder = $transportBuilder;
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
    }

    public function execute($orderId) : bool
    {
        if (!$orderId) {
            return false;
        }

        $order = $this->orderRepository->get($orderId);

        $transport = $this->transportBuilder->setTemplateIdentifier(self::COMPLETE_ORDER_EMAIL_TEMPLATE_ID)
            ->setTemplateVars([])
            ->setTemplateOptions(
                [
                    'area'=>\Magento\Framework\App\Area::AREA_FRONTEND,
                    'store'=> $order->getStoreId()
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
