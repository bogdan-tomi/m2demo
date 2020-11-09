<?php declare(strict_types=1);

namespace Evozon\M2Demo\Controller\Evozon;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class RequireJs implements HttpGetActionInterface
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
