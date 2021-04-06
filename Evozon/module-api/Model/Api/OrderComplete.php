<?php declare(strict_types=1);
/**
 * This file was created to provide the implementation for the complete order new API method,
 * as the basic usage of invoice, shipping order interfaces then an event dispatched for post-processing
 * (in this case the sending of the custom email template)
 *
 * @package     Evozon_Api
 * @subpackage  Model
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Model\Api;

use Evozon\Api\Api\OrderCompleteInterface;
use Evozon\Api\Model\SendOrderCompleteEmailInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Sales\Api\Data\InvoiceCommentCreationInterface;
use Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface;
use Magento\Sales\Api\Data\ShipmentCommentCreationInterface;
use Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface;
use Magento\Sales\Api\InvoiceOrderInterface;
use Magento\Sales\Api\ShipOrderInterface;

class OrderComplete implements OrderCompleteInterface
{
    /**
     * @var InvoiceOrderInterface
     */
    private InvoiceOrderInterface $invoiceOrder;
    /**
     * @var ShipOrderInterface
     */
    private ShipOrderInterface $shipOrder;
    /**
     * @var SendOrderCompleteEmailInterface
     */
    private SendOrderCompleteEmailInterface $sendOrderEmail;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $eventManager;

    /**
     * OrderComplete constructor
     */
    public function __construct(
        InvoiceOrderInterface $invoiceOrder,
        ShipOrderInterface $shipOrder,
        SendOrderCompleteEmailInterface $sendOrderEmail,
        ManagerInterface $eventManager
    ) {
        $this->invoiceOrder = $invoiceOrder;
        $this->shipOrder = $shipOrder;
        $this->sendOrderEmail = $sendOrderEmail;
        $this->eventManager = $eventManager;
    }

    /**
     * Takes an order from pending to complete then sends a custom email
     *
     * @param int $orderId
     * @param array $items
     * @param false $notify
     * @param false $appendComment
     * @param ShipmentCommentCreationInterface|null $shipComment
     * @param array $tracks
     * @param array $packages
     * @param ShipmentCreationArgumentsInterface|null $shipArguments
     * @param false $capture
     * @param InvoiceCommentCreationInterface|null $invoiceComment
     * @param InvoiceCreationArgumentsInterface|null $invoiceArguments
     *
     * @throws \Magento\Sales\Api\Exception\CouldNotInvoiceExceptionInterface
     * @throws \Magento\Sales\Api\Exception\CouldNotShipExceptionInterface
     * @throws \Magento\Sales\Api\Exception\DocumentValidationExceptionInterface
     *
     * @return string|void
     */
    public function execute(
        $orderId,
        array $items = [],
        $notify = false, //todo separate all parameters for invoice / shipping
        $appendComment = false,
        ShipmentCommentCreationInterface $shipComment = null,
        array $tracks = [],
        array $packages = [],
        ShipmentCreationArgumentsInterface $shipArguments = null,
        $capture = false,
        InvoiceCommentCreationInterface $invoiceComment = null,
        InvoiceCreationArgumentsInterface $invoiceArguments = null
    ) {
        // we don't have any custom parameters that need to be validated, all the parameters are validated by the
        // used existing methods
        $this->invoiceOrder->execute($orderId, $capture, $items, $notify, $appendComment, $invoiceComment, $invoiceArguments);
        // further processing is prevented by the existing logic in the invoice order process
        $this->shipOrder->execute($orderId, $items, $notify, $appendComment, $shipComment, $tracks, $packages, $shipArguments);
        // further processing is prevented by the existing logic in the ship order process

        // this is only reached when invoice and shipping have been successful
        $this->eventManager->dispatch('evozon_api_order_complete_after', ['order_id' => $orderId]);
    }
}
