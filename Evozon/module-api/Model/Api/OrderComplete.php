<?php declare(strict_types=1);

namespace Evozon\Api\Model\Api;

use Evozon\Api\Api\OrderCompleteInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Api\Data\InvoiceCommentCreationInterface;
use Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface;
use Magento\Sales\Api\Data\ShipmentCommentCreationInterface;
use Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface;
use Magento\Sales\Api\InvoiceOrderInterface;
use Magento\Sales\Api\ShipOrderInterface;
use Zend_Mail;

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
     * @var TransportBuilder
     */
    private TransportBuilder $transportBuilder;
    private Zend_Mail $mail;

    /**
     * OrderComplete constructor
     */
    public function __construct(
        InvoiceOrderInterface $invoiceOrder,
        ShipOrderInterface $shipOrder,
        TransportBuilder $transportBuilder,
        Zend_Mail $mail
    ) {
        $this->invoiceOrder = $invoiceOrder;
        $this->shipOrder = $shipOrder;
        $this->transportBuilder = $transportBuilder;
        $this->mail = $mail;
    }

    public function execute(
        $orderId,
        array $items = [],
        $notify = false,
        $appendComment = false,
        ShipmentCommentCreationInterface $shipComment = null,
        array $tracks = [],
        array $packages = [],
        ShipmentCreationArgumentsInterface $shipArguments = null,
        $capture = false,
        InvoiceCommentCreationInterface $invoiceComment = null,
        InvoiceCreationArgumentsInterface $invoiceArguments = null,
        $emailSubject = null,
        $bodyHtml = null,
        $fromAddress = null,
        $toAddress = null
    ) {
        $this->invoiceOrder->execute($orderId, $capture, $items, $notify, $appendComment, $invoiceComment, $invoiceArguments);
        $this->shipOrder->execute($orderId, $items, $notify, $appendComment, $shipComment, $tracks, $packages, $shipArguments);
        $this->mail->setSubject($emailSubject)
            ->setBodyHtml($bodyHtml)
            ->setFrom($fromAddress)
            ->addTo($toAddress)
            ->send();
    }
}
