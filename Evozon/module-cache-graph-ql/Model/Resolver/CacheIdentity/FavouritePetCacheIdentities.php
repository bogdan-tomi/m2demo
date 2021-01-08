<?php declare(strict_types=1);

namespace Evozon\CacheGraphQl\Model\Resolver\CacheIdentity;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class FavouritePetCacheIdentities implements IdentityInterface
{
    // the Magento\Framework\DataObject\IdentityInterface should be also implemented by the ORM model
    // in order for the graphQL query to be refreshed when the entity is changed
    public const CACHE_TAG = 'fav_p';

    public function getIdentities(array $resolvedData): array
    {
        // create an array of tags using unique data on the $resolvedData array
        $tags = $resolvedData['model'] !== '' ? [self::CACHE_TAG . '_' . $resolvedData['model']] : null;

        // we need to add the entity cache to the array if there are any values (i.e. any set favourite pet)
        return $tags ? array_merge($tags, [self::CACHE_TAG]) : [];
    }
}
