<?php
/**
 * This file was created to
 *
 * @package     Evozon_
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */


namespace Evozon\Api\Api;

interface SendOrderCompleteEmailInterface
{
    const COMPLETE_ORDER_EMAIL_TEMPLATE_CODE = 'evozon_complete_order';

    const XML_PATH_COMPLETE_ORDER_EMAIL_FIELD = 'hidden_evozon_sales/hidden_sales_general_configurations/hidden_complete_order_email_template';

    /**
     * @param int $orderId
     * @return bool
     */
    public function execute($orderId) : bool;

}
