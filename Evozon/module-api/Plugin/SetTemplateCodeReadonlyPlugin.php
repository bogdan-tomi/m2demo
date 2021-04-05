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

namespace Evozon\Api\Plugin;

class SetTemplateCodeReadonlyPlugin
{
    public function beforeSetForm(
        \Magento\Email\Block\Adminhtml\Template\Edit\Form $subject,
        \Magento\Framework\Data\Form $form
    ) {
        // disable editing the template code in admin for the complete order email template
        if ($form->getElement('template_code') && $form->getElement('template_code')->getValue() ===
            \Evozon\Api\Model\SendOrderCompleteEmailInterface::COMPLETE_ORDER_EMAIL_TEMPLATE_CODE) {
            $form->getElement('template_code')->setReadonly(true, true);
        }
        return [$form];
    }

}
