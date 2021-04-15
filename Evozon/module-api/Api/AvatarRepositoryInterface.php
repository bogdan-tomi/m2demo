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

namespace Evozon\Api\Api;

use Evozon\Api\Api\Data\AvatarInterface;

interface AvatarRepositoryInterface
{
    public function save(AvatarInterface $avatar): void;

    public function getByCustomerId(int $customerId): AvatarInterface;
}
