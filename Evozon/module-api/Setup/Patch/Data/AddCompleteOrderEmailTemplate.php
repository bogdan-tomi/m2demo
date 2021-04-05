<?php declare(strict_types=1);
/**
 * This file was created to
 *
 * @package     Evozon_
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCompleteOrderEmailTemplate implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * AddCompleteOrderEmailTemplate constructor.
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        // insert the new template into email_template
        $completeOrderEmail = [
            'template_code' => \Evozon\Api\Model\SendOrderCompleteEmailInterface::COMPLETE_ORDER_EMAIL_TEMPLATE_CODE,
            'template_type' => \Magento\Framework\App\TemplateTypesInterface::TYPE_HTML
        ];

        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('email_template'),
            $completeOrderEmail
        );

        // retrieve the template id, to be associated with our config field that reflects the complete order email template
        $templateId = $this->moduleDataSetup->getConnection()->lastInsertId(
            $this->moduleDataSetup->getTable('email_template')
        );

        $completeOrderEmailConfig = [
            'path'  => \Evozon\Api\Model\SendOrderCompleteEmailInterface::XML_PATH_COMPLETE_ORDER_EMAIL_FIELD,
            'value' => $templateId
        ];

        // Magento sets the actual template id as the auto increment id used in email_template, not the template code
        $this->moduleDataSetup->getConnection()->insertMultiple(
            $this->moduleDataSetup->getTable('core_config_data'),
            $completeOrderEmailConfig
        );

        return $this;
    }
}
