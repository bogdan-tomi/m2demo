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

    public function execute(Observer $observer)
    {
        $this->sendOrderEmail->execute($observer->getOrderId());
    }
}
