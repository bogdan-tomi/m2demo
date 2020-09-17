<?php declare(strict_types=1);

namespace Evozon\M2Demo\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;

class LogProductIdBeforeLoadPlugin
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beforeGetById(
        ProductRepositoryInterface $subject,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    ) {
//        $productId++;
        $this->logger->info("Logging before retrieving product by ID $productId");
//        return [$productId, $editMode, $storeId, $forceReload];
    }
}
