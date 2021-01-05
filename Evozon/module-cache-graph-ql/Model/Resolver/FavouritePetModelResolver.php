<?php declare(strict_types=1);

namespace Evozon\CacheGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FavouritePetModelResolver implements ResolverInterface
{
    const DEFAULT_PET = 'rock';

    // this resolver is kinda unnecessary as the default behaviour is the one implemented here,
    // the value returned uses the schema declared key
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        // the $value parameter contains the value of the parent resolver (null in most cases)
        return $value['model'] !== '' ? $value['model'] : self::DEFAULT_PET;
    }
}
