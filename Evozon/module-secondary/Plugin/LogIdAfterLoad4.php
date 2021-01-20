<?php declare(strict_types=1);

namespace Evozon\Secondary\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;

class LogIdAfterLoad4
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
        $this->logger->info("4Logging before retrieving product by ID $productId");

    }

    // around plugins should only be used to substitute the behaviour of the original method,
    // or if the plugin is required to track some state from before and after the invocation
//    public function aroundGetById(
//        ProductRepositoryInterface $subject,
//        callable $proceed,
//        $productId,
//        $editMode = false,
//        $storeId = null,
//        $forceReload = false
//        //...$args can be used here instead of all the arguments, for a more upgradable approach
//    ) {
//        $this->logger->info("4Logging around before retrieving product by ID $productId");
//        $result = $proceed($productId, $editMode, $storeId, $forceReload);
//        //$result = $proceed(...$args);
//        $this->logger->info("4Logging around after retrieving product by ID $productId");
//
//        return $result;
//    }

    public function afterGetById(
        ProductRepositoryInterface $subject,
        ProductInterface $result,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    ) {
        $this->logger->info("4Logging after retrieving product by ID $productId");

        return $result;
    }
}
