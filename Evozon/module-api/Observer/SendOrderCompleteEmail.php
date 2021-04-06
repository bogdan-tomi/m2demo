<?php declare(strict_types=1);
/**
 * This observer was created to send a custom email
 *
 * @package     Evozon_Api
 * @subpackage  Observer
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Observer;

use Evozon\Api\Model\SendOrderCompleteEmailInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SendOrderCompleteEmail implements ObserverInterface
{
    /**
     * @var SendOrderCompleteEmailInterface
     */
    private SendOrderCompleteEmailInterface $sendOrderEmail;

    /**
     * SendOrderCompleteEmail constructor.
     */
    public function __construct(SendOrderCompleteEmailInterface $sendOrderEmail)
    {
        $this->sendOrderEmail = $sendOrderEmail;
    }

    /**
     * Sends a custom email
     *
     * @event evozon_api_order_complete_after
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->sendOrderEmail->execute($observer->getOrderId());
    }
}
