<?php

namespace Evozon\M2Demo\Model;

use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfigInterface;

class Config
{
    private const XML_PATH_EVOZON_M2DEMO_NAME_CHANGE =
        'evozon_m2_general_configurations/hello_world_configurations/enabled';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isNameChangeEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_EVOZON_M2DEMO_NAME_CHANGE);
    }
}
