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
    const COMPLETE_ORDER_EMAIL_TEMPLATE_ID = 'evozon_api_complete_order';

    /**
     * @param int $orderId
     * @return bool
     */
    public function execute($orderId) : bool;

}
