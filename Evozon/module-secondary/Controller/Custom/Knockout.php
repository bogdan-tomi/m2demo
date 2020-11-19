<?php declare(strict_types=1);

namespace Evozon\Secondary\Controller\Custom;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Knockout implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    public function __construct(PageFactory $pageFactory)
    {
        $this->resultPageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
