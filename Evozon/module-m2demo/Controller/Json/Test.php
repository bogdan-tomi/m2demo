<?php declare(strict_types=1);

namespace Evozon\M2Demo\Controller\Json;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\EntityManager\EventManager;

class Test implements HttpGetActionInterface
{
    const CUSTOM_EVENT = 'custom_event';

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;
    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    public function __construct(JsonFactory $resultJsonFactory, EventManager $eventManager)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $data = ['message' => 'Hello World'];
        $this->eventManager->dispatch(self::CUSTOM_EVENT, $data);
        return $result->setData($data);
    }
}
