<?php declare(strict_types=1);

namespace Evozon\M2Demo\Controller\RequireJs;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Dependency implements HttpGetActionInterface
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
