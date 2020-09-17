<?php declare(strict_types=1);

namespace Evozon\Secondary\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;

class LogIdAfterLoad
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function aroundGetById(
        ProductRepositoryInterface $subject,
        callable $proceed,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    ) {
        $this->logger->info("Logging around before retrieving product by ID $productId");
        $result = $proceed($productId, $editMode, $storeId, $forceReload);
        $this->logger->info("Logging around after retrieving product by ID $productId");

        return $result;
    }

    public function afterGetById(
        ProductRepositoryInterface $subject,
        ProductInterface $result,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    ) {
        $this->logger->info("Logging after retrieving product by ID $productId");

        return $result;
    }
}
