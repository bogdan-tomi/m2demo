<?php declare(strict_types=1);

namespace Evozon\Api\Model\Api;

use Evozon\Api\Api\OrderCompleteInterface;
use Evozon\Api\Api\SendOrderCompleteEmailInterface;
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

    // todo refactor docblocks
    // todo add comments
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
        // todo add validation
//        $this->invoiceOrder->execute($orderId, $capture, $items, $notify, $appendComment, $invoiceComment, $invoiceArguments);
        // todo add stop further processing if this fails (check returned values)
//        $this->shipOrder->execute($orderId, $items, $notify, $appendComment, $shipComment, $tracks, $packages, $shipArguments);
        // todo add stop further processing if this fails (check returned values)

        $this->eventManager->dispatch('evozon_api_order_complete_after', ['order_id' => $orderId]);
    }
}
