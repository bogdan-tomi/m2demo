<?php declare(strict_types=1);

namespace Evozon\Cache\Controller\Block;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\View\Result\LayoutFactory as LayoutResultFactory;

// controller for the ajax request for hole punch
class Index implements HttpGetActionInterface
{
    /**
     * @var LayoutResultFactory
     */
    private LayoutResultFactory $layoutResultFactory;
    /**
     * @var HttpResponse
     */
    private HttpResponse $httpResponse;

    public function __construct(LayoutResultFactory $layoutResultFactory, HttpResponse $httpResponse)
    {
        $this->layoutResultFactory = $layoutResultFactory;
        $this->httpResponse = $httpResponse;
    }

    public function execute()
    {
        $result = $this->layoutResultFactory->create();

        // add a custom handle that contains a block for the custom county logic
        $result->addHandle('evozon_cache_ajax_visitor_county');

        // set the time-to-live to 20 seconds on the http response, so we can cache the ajax response in the browser http cache
        // commented so the browser session storage is used instead
//        $this->httpResponse->setPrivateHeaders(20);

        return $result; // remember to return result
    }
}
