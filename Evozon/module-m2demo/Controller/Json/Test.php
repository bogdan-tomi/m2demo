<?php declare(strict_types=1);

namespace Evozon\M2Demo\Controller\Json;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Test implements HttpGetActionInterface
{
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    public function __construct(JsonFactory $resultJsonFactory)
    {
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $data = ['message' => 'Hello World'];
        return $result->setData($data);
    }
}
