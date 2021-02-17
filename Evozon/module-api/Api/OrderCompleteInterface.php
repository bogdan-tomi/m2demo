<?php


namespace Evozon\Api\Api;


use Magento\Sales\Api\Data\InvoiceCommentCreationInterface;
use Magento\Sales\Api\Data\InvoiceCreationArgumentsInterface;
use Magento\Sales\Api\Data\InvoiceItemCreationInterface;
use Magento\Sales\Api\Data\ShipmentCommentCreationInterface;
use Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface;
use Magento\Sales\Api\Data\ShipmentPackageCreationInterface;
use Magento\Sales\Api\Data\ShipmentTrackCreationInterface;

interface OrderCompleteInterface
{


    /**
     * --description
     *
     * @param int $orderId
     * @param InvoiceItemCreationInterface[] $items
     * @param bool|false $notify
     * @param bool|false $appendComment
     * @param ShipmentCommentCreationInterface|null $shipComment
     * @param ShipmentTrackCreationInterface[] $tracks
     * @param ShipmentPackageCreationInterface[] $packages
     * @param ShipmentCreationArgumentsInterface|null $shipArguments
     * @param bool|false $capture
     * @param InvoiceCommentCreationInterface|null $invoiceComment
     * @param InvoiceCreationArgumentsInterface|null $invoiceArguments
     *
     * @return string
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
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
        InvoiceCreationArgumentsInterface $invoiceArguments = null
    );
}
