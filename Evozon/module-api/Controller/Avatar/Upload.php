<?php declare(strict_types=1);
/**
 * This Controller action checks the customer authentication and uploads the avatar
 *
 * @package     Evozon_Api
 * @subpackage  Controller
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\Controller\Avatar;

use Evozon\Api\Api\AvatarUploadInterface;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrlModel;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

// we need to use the post interface when submitting forms
class Upload implements HttpPostActionInterface
{
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;
    /**
     * @var AvatarUploadInterface
     */
    private AvatarUploadInterface $avatarUpload;
    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var CustomerUrlModel
     */
    private CustomerUrlModel $customerUrlModel;

    /**
     * @param Session $customerSession
     */
    public function __construct(
        Session $customerSession,
        RedirectFactory $redirectFactory,
        AvatarUploadInterface $avatarUpload,
        CustomerUrlModel $url
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->avatarUpload = $avatarUpload;
        $this->customerSession = $customerSession;
        $this->customerUrlModel = $url;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        // redirect if user is not logged in
        if (!$this->customerSession->authenticate()) {
            return $this->redirectFactory->create()->setPath(
                $this->customerUrlModel->getLoginUrl()
            );
        }

        // upload the image using the custom API
        $this->avatarUpload->upload();

        // redirect to the edit avatar page
        return $this->redirectFactory->create()->setPath('evozon_api/avatar/edit');
    }
}
