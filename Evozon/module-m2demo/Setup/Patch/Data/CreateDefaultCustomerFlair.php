<?php


namespace Evozon\M2Demo\Setup\Patch\Data;


use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class CreateDefaultCustomerFlair implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        // this should be used only for internal dependencies, dependencies to other modules should be reflected
        // in the require{} section of composer.json and etc/module.xml <sequence> tags,
        // the suggest{} section of composer.json is used for soft dependencies, such as directly check another
        // module’s availability, extend another module’s configuration, and extend another module’s layout.
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        // if we change the name of the data patch, we need to include it in this array
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $customerFlairs = [
            [
                'nickname' => 'Ghandi',
                'customer_id' => 1,
                'motto' => 'The greatness of humanity is not in being human, but in being humane.'
            ]
        ];
        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('evozon_m2demo_customer_flair'),
            $customerFlairs
        );
        return $this;
    }
}
