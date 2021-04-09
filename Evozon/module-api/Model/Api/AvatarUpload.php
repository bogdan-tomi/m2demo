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

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\File\UploaderFactory;

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
     * AvatarUpload constructor.
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        JsonFactory $jsonFactory,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Cms\Helper\Wysiwyg\Images $cmsWysiwygImages,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->jsonFactory = $jsonFactory;
        $this->directoryList = $directoryList;
        $this->cmsWysiwygImages = $cmsWysiwygImages;
        $this->storeManager = $storeManager;
    }

    public function execute()
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
            $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $result['id'] = $this->cmsWysiwygImages->idEncode($result['file']);
            $result['url'] = $baseUrl . $this->getFilePath(self::UPLOAD_DIR, $result['file']);
        } catch (\Exception $e) {
            $result = [
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode()
            ];
        }
        return $result;
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
