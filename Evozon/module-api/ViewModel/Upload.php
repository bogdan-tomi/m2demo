<?php declare(strict_types=1);
/**
 * This file was created to serve as a viewmodel with custom presentation logic for the avatar upload form
 *
 * @package     Evozon_Api
 * @subpackage  ViewModel
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Api\ViewModel;

use Evozon\Api\Model\Api\AvatarUpload;

class Upload implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    private AvatarUpload $avatarUpload;


    /**
     * Upload constructor.
     */
    public function __construct(
        AvatarUpload $avatarUpload
    ) {
        $this->avatarUpload = $avatarUpload;
    }

    public function getFormAction(): string
    {
        return '/evozon_api/avatar/upload/';
    }

    public function getCurrentUserAvatar(): string
    {
        return $this->avatarUpload->retrieve();
    }

}
