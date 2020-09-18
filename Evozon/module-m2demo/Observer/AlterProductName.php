<?php declare(strict_types=1);

namespace Evozon\M2Demo\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AlterProductName implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();
        $product->setName('«' . $product->getName() . '»');
    }
}
