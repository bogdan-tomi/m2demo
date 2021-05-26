<?php declare(strict_types=1);
/**
 * This file was created to extract the data from the invitation object to a suitable array for GraphQL
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Invitation\Model\Invitation;

use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Webapi\ServiceOutputProcessor;
use Magento\Invitation\Model\Invitation;

class ExtractInvitationData
{
    /**
     * @var DataObjectProcessor
     */
    private DataObjectProcessor $dataObjectProcessor;

    /**
     * InvitationData constructor.
     * @param ServiceOutputProcessor $serviceOutputProcessor
     */
    public function __construct(DataObjectProcessor $dataObjectProcessor)
    {
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Extract the invitation data as an array
     *
     * @param Invitation $invitation
     * @return array
     */
    public function execute(Invitation $invitation) : array
    {
        //todo this is where the object data could be manipulated further to be returned as an array for GraphQL

//        $invitationData = $this->dataObjectProcessor->buildOutputDataArray(
//            $invitation,
//            Invitation::class
//        );

        $invitationData['email'] = $invitation->getEmail();
        $invitationData['status'] = $invitation->getStatus();

        // we need to return an array having the keys established in schema.graphqls for Invitation
        return $invitationData;
    }
}
