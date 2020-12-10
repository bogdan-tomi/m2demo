<?php declare(strict_types=1);

namespace Evozon\Cache\Plugin;

use Evozon\Cache\Model\FavouritePetSession;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Http\Context as HttpContext;

class FavouritePetCacheSegmentationPlugin
{
    /**
     * @var HttpContext
     */
    private HttpContext $httpContext;
    /**
     * @var FavouritePetSession
     */
    private FavouritePetSession $favouritePetSession;

    /**
     * FavouritePetCacheSegmentationPlugin constructor
     */
    public function __construct(HttpContext $httpContext, FavouritePetSession $favouritePetSession)
    {
        $this->httpContext = $httpContext;
        $this->favouritePetSession = $favouritePetSession;
    }

    public function afterExecute(ActionInterface $subject, $result)
    {
        $favouritePet = $this->favouritePetSession->getFavouritePet();
        $defaultPet = '';

        $this->httpContext->setValue('EVOZON_CACHE_FAVOURITE_PET', $favouritePet, $defaultPet);

        return $result;
    }
}
