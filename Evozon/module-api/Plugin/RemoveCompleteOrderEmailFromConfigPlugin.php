<?php declare(strict_types=1);
/**
 * This plugin was created to hide the custom email template from the email config
 * so it cannot be used with other operations
 *
 * @package     Evozon_Api
 * @subpackage  Plugin
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Plugin;

use \Evozon\Api\Model\SendOrderCompleteEmailInterface as EvozonApiEmail;

class RemoveCompleteOrderEmailFromConfigPlugin
{
    /**
     * Hides the custom email template
     *
     * @param \Magento\Config\Model\Config\Source\Email\Template $subject
     * @param $result
     * @return array
     */
    public function afterToOptionArray(
        \Magento\Config\Model\Config\Source\Email\Template $subject,
        $result
    ) {
        foreach ($result as $key => $option) {
            if (isset($option['label']) && $option['label'] === EvozonApiEmail::COMPLETE_ORDER_EMAIL_TEMPLATE_CODE) {
                unset($result[$key]);
                return $result;
            }
        }
        return $result;
    }
}
