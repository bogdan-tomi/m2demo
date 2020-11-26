<?php declare(strict_types=1);

namespace Evozon\Cache\Block;

use Evozon\Cache\Model\Counties as CountiesAlias;
use Magento\Framework\View\Element\Template as Template;
use Magento\Framework\View\Element\Template\Context;

class County extends Template
{
    /**
     * @var CountiesAlias
     */
    private CountiesAlias $countiesModel;

    /*
     * @var array[]
     */
    private static array $cachedCounties = [];

    public function __construct(Context $context, CountiesAlias $countiesModel, array $data = [])
    {
        parent::__construct($context, $data);
        $this->countiesModel = $countiesModel;
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
        $counties = $this->countiesModel->getAllCounties();
        self::$cachedCounties[$ip] = $counties[array_rand($counties)];
        return sprintf('Hello %s county!', self::$cachedCounties[$ip]);
    }
}
