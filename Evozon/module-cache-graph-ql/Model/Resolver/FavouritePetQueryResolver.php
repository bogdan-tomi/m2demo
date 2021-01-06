<?php declare(strict_types=1);

namespace Evozon\CacheGraphQl\Model\Resolver;

use Evozon\Cache\Model\FavouritePetSession;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FavouritePetQueryResolver implements ResolverInterface
{
    private FavouritePetSession $petSession;

    public function __construct(FavouritePetSession $petSession)
    {
        $this->petSession = $petSession;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        // the return type here must match the one declared in the etc/schema.graphqls

        // we can use the context to check if customers are logged in
        /** @var $context \Magento\GraphQl\Model\Query\ContextInterface  */
        if ($this->isCustomerLoggedIn($context)) {
            return [
                'model' => $this->petSession->getFavouritePetByCustomerId($context->getUserId())
                ];
        }
        return [
                'model' => $this->petSession->getFavouritePet()
            ];
    }

    private function isCustomerLoggedIn(ContextInterface $context): bool
    {
        // this value is only set when the customer is logged in
        /** @var $context \Magento\GraphQl\Model\Query\ContextInterface  */
        return $context->getUserType() === UserContextInterface::USER_TYPE_CUSTOMER;
    }

}
