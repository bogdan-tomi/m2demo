<?php declare(strict_types=1);

namespace Evozon\M2Demo\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Evozon\M2Demo\Model\Config;

class AlterProductName implements ObserverInterface
{

    /**
     * @var Config
     */
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function execute(Observer $observer)
    {
        if (!$this->config->isNameChangeEnabled()) {
            return;
        }
        $product = $observer->getProduct();
        $product->setName('«' . $product->getName() . '»');
    }
}
