<?php
/**
 * This interface was created to provide decoupling for the invitation API operations
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */


namespace Evozon\Invitation\Api;


interface CreateInvitationInterface
{
    /**
     * Returns true if the request contains a valid invitation
     *
     * @return bool
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function CreateInvitation();

    /**
     * Returns the login token if a customer has been created successfully post-invitation
     *
     * @return string
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function CreateInvitationPost();
}
