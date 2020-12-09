<?php declare(strict_types=1);

namespace Evozon\Cache\Controller\Cache;

use Evozon\Cache\Model\FavouritePetSession;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Segmentation implements HttpGetActionInterface
{
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var FavouritePetSession
     */
    private FavouritePetSession $favouritePetSession;

    public function __construct(RedirectFactory $redirectFactory, RequestInterface $request, FavouritePetSession $favouritePetSession)
    {
        $this->redirectFactory = $redirectFactory;
        $this->request = $request;
        $this->favouritePetSession = $favouritePetSession;
    }

    public function execute()
    {
        $favouritePet = $this->request->getParam('pet');
        $this->favouritePetSession->setFavouritePet($favouritePet);

        $redirect = $this->redirectFactory->create();
        $redirect->setRefererOrBaseUrl();
        return $redirect;
    }
}
