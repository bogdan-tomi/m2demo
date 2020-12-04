<?php declare(strict_types=1);

namespace Evozon\Cache\Block;

use Evozon\Cache\Model\Counties;
use Magento\Framework\View\Element\Template as Template;

class County extends Template
{
    /*
     * @var array[]
     */
    private static array $cachedCounties = [];

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
        // retrieve the counties model given as an argument from the layout file,
        // instead of injecting it in the constructor
        $countiesModel = $this->getCountiesModel();
        $counties = $countiesModel->getAllCounties();

        self::$cachedCounties[$ip] = $counties[array_rand($counties)];
        return sprintf('Hello %s county!', self::$cachedCounties[$ip]);
    }

}
