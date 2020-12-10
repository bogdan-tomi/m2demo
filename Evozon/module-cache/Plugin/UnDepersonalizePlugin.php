<?php declare(strict_types=1);

namespace Evozon\Cache\Plugin;

use Evozon\Cache\Model\FavouritePetSession;
use Magento\Framework\View\LayoutInterface;
use Magento\PageCache\Model\DepersonalizeChecker;

class UnDepersonalizePlugin
{

    /**
     * @var FavouritePetSession
     */
    private FavouritePetSession $favouritePetSession;
    /**
     * @var DepersonalizeChecker
     */
    private DepersonalizeChecker $depersonalizeChecker;

    private string $petValue;

    public function __construct(
        FavouritePetSession $favouritePetSession,
        DepersonalizeChecker $depersonalizeChecker
    )
    {
        $this->favouritePetSession = $favouritePetSession;
        $this->depersonalizeChecker = $depersonalizeChecker;
    }

    public function beforeGenerateXml(LayoutInterface $subject)
    {
        if ($this->depersonalizeChecker->checkIfDepersonalize($subject)) {
            $this->petValue = $this->favouritePetSession->getFavouritePet();
        }
    }

    public function afterGenerateXml(LayoutInterface $subject, $result)
    {
        if ($this->petValue && $this->depersonalizeChecker->checkIfDepersonalize($subject)) {
            $this->favouritePetSession->setFavouritePet($this->petValue);
        }
        return $result;
    }
}
