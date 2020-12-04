<?php declare(strict_types=1);

namespace Evozon\Cache\Controller\Block;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\LayoutFactory as LayoutResultFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @var LayoutResultFactory
     */
    private LayoutResultFactory $layoutResultFactory;

    public function __construct(LayoutResultFactory $layoutResultFactory)
    {
        $this->layoutResultFactory = $layoutResultFactory;
    }

    public function execute()
    {
        $result = $this->layoutResultFactory->create();
        $result->addHandle('default');
        return $result; // remember to return result
    }
}
