<?php declare(strict_types=1);

namespace Evozon\M2Demo\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class CustomEventObserver implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CustomEventObserver constructor
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $this->logger->info('Observers should not change data (like M1), plugins should be used instead.');
        $this->logger->info('Data from observer = ' . $observer->getData('message'));
    }
}
