<?php declare(strict_types=1);

namespace Evozon\CacheGraphQl\Model\Resolver;

use Evozon\Cache\Model\FavouritePetSession;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FavouritePetResolver implements ResolverInterface
{
    private FavouritePetSession $petSession;

    public function __construct(FavouritePetSession $petSession)
    {
        $this->petSession = $petSession;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        // the return type here must match the one declared in the etc/schema.graphqls
        return $this->petSession->getFavouritePet();
    }
}
