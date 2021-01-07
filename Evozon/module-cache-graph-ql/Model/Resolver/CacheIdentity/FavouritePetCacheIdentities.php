<?php declare(strict_types=1);

namespace Evozon\CacheGraphQl\Model\Resolver\CacheIdentity;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class FavouritePetCacheIdentities implements IdentityInterface
{
    public function getIdentities(array $resolvedData): array
    {
        return ['dummy'];
    }
}
