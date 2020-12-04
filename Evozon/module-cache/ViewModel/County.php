<?php declare(strict_types=1);

namespace Evozon\Cache\ViewModel;

use Evozon\Cache\Model\Counties;
use Magento\Framework\View\Element\Block\ArgumentInterface;

// Magento prefers this implementation over creating a block that extends the Template
class County implements ArgumentInterface // we need to implement this interface when using the object as a block argument
{
    /*
     * @var array[]
     */
    private static array $cachedCounties = [];
    /**
     * @var Counties
     */
    private Counties $counties;

    public function __construct(Counties $counties)
    {
        $this->counties = $counties;
    }

    public function getWelcomeText(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        return $this->getCounty($ip);
    }

    public function getCounty(string $ip): string
    {
        if (isset(self::$cachedCounties[$ip])) {
            return self::$cachedCounties[$ip];
        }

        /** @var Counties $countiesModel */
        // retrieve the counties model given as a constructor injection
        $counties = $this->counties->getAllCounties();

        self::$cachedCounties[$ip] = $counties[array_rand($counties)];
        return sprintf('Hello %s county!', self::$cachedCounties[$ip]);
    }
}
