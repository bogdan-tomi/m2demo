<?php declare(strict_types=1);

namespace Evozon\CacheGraphQl\Model\Resolver;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FavouritePetProductsResolver implements ResolverInterface
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(ProductRepository $productRepository, SearchCriteriaBuilder $searchCriteriaBuilder)
    {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $this->searchCriteriaBuilder->addFilter('name', chr(rand(97,122)) . '%', 'like');
        $result = $this->productRepository->getList($this->searchCriteriaBuilder->create());
        $products = $result->getItems();

        // todo each product needs to be converted from product model instances to arrays
        return [];
    }
}
