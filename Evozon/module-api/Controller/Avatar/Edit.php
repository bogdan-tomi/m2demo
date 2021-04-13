<?php declare(strict_types=1);
/**
 * This Controller action checks the customer authentication and displays the edit avatar page
 *
 * @package     Evozon_Api
 * @subpackage  Controller
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Controller\Avatar;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrlModel;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;

class Edit implements HttpGetActionInterface
{

   /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var CustomerUrlModel
     */
    private CustomerUrlModel $customerUrlModel;
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $pageFactory,
        RedirectFactory $redirectFactory,
        CustomerUrlModel $url
    ) {
        $this->customerSession = $customerSession;
        $this->pageFactory = $pageFactory;
        $this->customerUrlModel = $url;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        if (!$this->customerSession->authenticate()) {
            return $this->redirectFactory->create()->setPath(
                $this->customerUrlModel->getLoginUrl()
            );
        }
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Avatar'));

        return $resultPage;
    }
}
