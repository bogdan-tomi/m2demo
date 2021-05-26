<?php declare(strict_types=1);
/**
 * This file was created to persist the new invitation
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Invitation\Model\Invitation;

use Evozon\Invitation\Api\InvitationInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlAlreadyExistsException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Invitation\Model\Invitation;
use Magento\Invitation\Model\InvitationFactory;
use Magento\Invitation\Model\ResourceModel\Invitation\CollectionFactory;
use Psr\Log\LoggerInterface;

class CreateInvitation
{
    /**
     * @var DataObjectHelper
     */
    private DataObjectHelper $dataObjectHelper;

    /**
     * @var InvitationInterface
     */
    private InvitationInterface $invitationRepository;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $invitationCollectionFactory;

    /**
     * @var InvitationFactory
     */
    private InvitationFactory $invitationFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Escaper
     */
    private Escaper $escaper;


    /**
     * CreateInvitation constructor
     */
    public function __construct(
        InvitationFactory $invitationFactory,
        DataObjectHelper $dataObjectHelper,
        InvitationInterface $invitationRepository,
        CollectionFactory $invitationCollectionFactory,
        LoggerInterface $logger,
        Escaper $escaper
    ) {
        $this->invitationFactory = $invitationFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->invitationRepository = $invitationRepository;
        $this->invitationCollectionFactory = $invitationCollectionFactory;
        $this->logger = $logger;
        $this->escaper = $escaper;
    }

    /**
     * Creates a new invitation
     *
     * @param array $data
     * @return Invitation
     * @throws GraphQlAlreadyExistsException
     * @throws GraphQlInputException
     * @throws LocalizedException
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function execute(array $data): Invitation
    {
        return $this->createInvitation($data);
    }

    /**
     * Adds the invitation data to the database using a model and the repository, then returns the said model
     *
     * @param array $data
     * @return Invitation
     * @throws GraphQlAlreadyExistsException
     * @throws GraphQlInputException
     * @throws LocalizedException
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function createInvitation(array $data): Invitation
    {
        //todo this is where we can add data validation
        // such as checking the config isInvitationMessageAllowed and overriding the messsage with empty string if false
        // or validating the email as being valid

        //todo adding the data to a invitation object using data object helper DOESN'T WORK
        // because the model doesn't have a proper interface containing all the get/set methods
        // for all its fields, so email and message are actually ignored
//        $this->dataObjectHelper->populateWithArray(
//            $invitationDataObject,
//            $data,
//            Invitation::class
//        );

        /** @var Invitation $invitationDataObject */
        $invitation = $this->invitationFactory->create();

        $invitation->setData($data);

        try {
            // persist the data to the database
            $this->invitationRepository->save($invitation);

            if (!$invitation->sendInvitationEmail()) {
                // not \Magento\Framework\Exception\LocalizedException intentionally, as Magento does
                throw new \Exception('');
            }
        } catch (\Magento\Framework\Exception\AlreadyExistsException $e) {
            throw new GraphQlAlreadyExistsException(__('We did not send the invitation addressed to current customer'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    'Something went wrong while sending an email to %1.',
                    $this->escaper->escapeHtml($invitation->getEmail())
                )
            );
        }

        // this should mean we are error free and the invitation has been successfully saved
        return $invitation;
    }
}
