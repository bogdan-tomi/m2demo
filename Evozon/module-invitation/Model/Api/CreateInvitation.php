<?php declare(strict_types=1);
/**
 * This model was created to provide the implementation for the invitation API operations
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */
namespace Evozon\Invitation\Model\Api;

use Evozon\Invitation\Api\CreateInvitationInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Model\Oauth\TokenFactory;
use Magento\Invitation\Model\InvitationProvider;
use Psr\Log\LoggerInterface;

class CreateInvitation implements CreateInvitationInterface
{
    /**
     * @var InvitationProvider
     */
    private InvitationProvider $invitationProvider;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var CustomerInterfaceFactory
     */
    private CustomerInterfaceFactory $customerInterfaceFactory;
    /**
     * @var AccountManagementInterface
     */
    private AccountManagementInterface $accountManagement;
    /**
     * @var SessionFactory
     */
    private SessionFactory $sessionFactory;
    /**
     * @var CustomerFactory
     */
    private CustomerFactory $customerFactory;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $eventManager;
    /**
     * @var TokenFactory
     */
    private TokenFactory $tokenFactory;


    /**
     * CreateInvitation constructor
     */
    public function __construct(
        InvitationProvider $invitationProvider,
        RequestInterface $request,
        LoggerInterface $logger,
        CustomerInterfaceFactory $customerInterfaceFactory,
        AccountManagementInterface $accountManagement,
        CustomerFactory $customerFactory,
        SessionFactory $sessionFactory,
        ManagerInterface $eventManager,
        TokenFactory $tokenFactory
    ) {
        $this->invitationProvider = $invitationProvider;
        $this->request = $request;
        $this->logger = $logger;
        $this->customerInterfaceFactory = $customerInterfaceFactory;
        $this->accountManagement = $accountManagement;
        $this->customerFactory = $customerFactory;
        $this->sessionFactory = $sessionFactory;
        $this->eventManager = $eventManager;
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * --description
     *
     * @return bool
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function CreateInvitation()
    {
        try {
            $this->invitationProvider->get($this->request);

        } catch (LocalizedException $e) {
            $this->logger->critical($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * --description
     *
     * @return bool
     * @throws \Exception
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function CreateInvitationPost()
    {
        try {
            $invitation = $this->invitationProvider->get($this->request);

            /** @var CustomerInterface $customer */
            $customer = $this->customerInterfaceFactory->create();
            $customer->setEmail($this->request->getParam('email'));
            $customer->setFirstname($this->request->getParam('firstname'));
            $customer->setLastname($this->request->getParam('lastname'));


            $newCustomer = $this->accountManagement->createAccount($customer, $this->request->getParam('password'));

            $invitation->accept($newCustomer->getWebsiteId(), $newCustomer->getId());

            $customerDataObject = $this->accountManagement->authenticate($newCustomer->getEmail(), $this->request->getParam('password'));
            $this->eventManager->dispatch('customer_login', ['customer' => $customerDataObject]);

            return $this->tokenFactory->create()->createCustomerToken($customerDataObject->getId())->getToken();

        } catch (LocalizedException $e) {
            //todo the exception catching could be more specific
            $this->logger->critical($e->getMessage());
            return false;
        }
        return true;
    }
}
