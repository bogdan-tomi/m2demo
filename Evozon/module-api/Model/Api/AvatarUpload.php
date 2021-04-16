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

namespace Evozon\Api\Model\Api;

use Evozon\Api\Api\AvatarRepositoryInterface;
use Evozon\Api\Api\Data\AvatarInterface;
use Evozon\Api\Api\Data\AvatarInterfaceFactory;
use Evozon\Api\Model\AvatarRepository;
use Magento\Authorization\Model\CompositeUserContext;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\UrlInterface;
use Psr\Log\LoggerInterface;

class AvatarUpload implements \Evozon\Api\Api\AvatarUploadInterface
{

    const UPLOAD_DIR = 'avatars';

    /**
     * @var UploaderFactory
     */
    private UploaderFactory $uploaderFactory;
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;
    private \Magento\Framework\Filesystem\DirectoryList $directoryList;
    private \Magento\Cms\Helper\Wysiwyg\Images $cmsWysiwygImages;
    private \Magento\Store\Model\StoreManagerInterface $storeManager;
    /**
     * @var AvatarRepositoryInterface
     */
    private AvatarRepositoryInterface $avatarRepository;
    /**
     * @var AvatarInterfaceFactory
     */
    private AvatarInterfaceFactory $avatarFactory;
    /**
     * @var CompositeUserContext
     */
    private CompositeUserContext $compositeUserContext;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;


    /**
     * AvatarUpload constructor.
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        JsonFactory $jsonFactory,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Cms\Helper\Wysiwyg\Images $cmsWysiwygImages,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        AvatarRepositoryInterface $avatarRepository,
        AvatarInterfaceFactory $avatarInterfaceFactory,
        CompositeUserContext $compositeUserContext,
        LoggerInterface $logger
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->jsonFactory = $jsonFactory;
        $this->directoryList = $directoryList;
        $this->cmsWysiwygImages = $cmsWysiwygImages;
        $this->storeManager = $storeManager;
        $this->avatarRepository = $avatarRepository;
        $this->avatarFactory = $avatarInterfaceFactory;
        $this->compositeUserContext = $compositeUserContext;
        $this->logger = $logger;
    }

    public function upload()
    {
        $fileUploader = $this->uploaderFactory->create(['fileId' => 'image']);

        $fileUploader->setFilesDispersion(false);
        $fileUploader->setAllowRenameFiles(true);
        $fileUploader->setAllowedExtensions(['jpeg', 'jpg', 'png', 'gif']);
        $fileUploader->setAllowCreateFolders(true);

        try {
            if (!$fileUploader->checkMimeType(['image/png', 'image/jpeg', 'image/gif'])) {
                throw new \Magento\Framework\Exception\LocalizedException(__('File validation failed.'));
            }

            $result = $fileUploader->save($this->getUploadDir());
            $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $result['id'] = $this->cmsWysiwygImages->idEncode($result['file']);
            $result['url'] = $baseUrl . $this->getFilePath(self::UPLOAD_DIR, $result['file']);

            $customerId = (int) $this->compositeUserContext->getUserId();

            /** @var AvatarInterface $avatar */
            $avatar = $this->avatarFactory->create();

            $avatar->setCustomerId($customerId);
            $avatar->setValue('/' . $result['file']);

            $this->avatarRepository->save($avatar);
        } catch (\Exception $e) {
            $result = [
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode()
            ];
        }
        return $result;
    }

    public function retrieve(): string
    {
        $this->logger->info('retrieve avatar');
        $customerId = (int) $this->compositeUserContext->getUserId();

        $avatar = $this->avatarRepository->getByCustomerId((int) $customerId);

        return DS . UrlInterface::URL_TYPE_MEDIA . DS
            . self::UPLOAD_DIR
            . $avatar->getValue();
    }

    /**
     * Return the upload directory
     *
     * @return string
     */
    private function getUploadDir()
    {
        return $this->directoryList->getPath('media') . DIRECTORY_SEPARATOR . self::UPLOAD_DIR;
    }

    /**
     * Retrieve path
     *
     * @param string $path
     * @param string $imageName
     * @return string
     */
    private function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

}
