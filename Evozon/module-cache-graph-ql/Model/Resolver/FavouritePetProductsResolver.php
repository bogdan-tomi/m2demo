<?php declare(strict_types=1);

namespace Evozon\CacheGraphQl\Model\Resolver;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product as ProductOrmModel;
use Magento\Catalog\Model\ProductFactory as ProductOrmModelFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Reflection\DataObjectProcessor;

use function array_map as map;
use function array_values as values;

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
    /**
     * @var DataObjectProcessor
     */
    private DataObjectProcessor $dataObjectProcessor;
    /**
     * @var ProductOrmModelFactory
     */
    private ProductOrmModelFactory $productOrmFactory;

    public function __construct(
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        DataObjectProcessor $dataObjectProcessor,
        ProductOrmModelFactory $productOrmModelFactory
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->productOrmFactory = $productOrmModelFactory;
    }

    private function createNewProductOrmModel(array $data) : ProductOrmModel
    {
        $productModel = $this->productOrmFactory->create(['data' => $data]);
        $productModel->setId($data['id']);
        return $productModel;
    }

    private function productDtoToArray(ProductInterface $product): array
    {
        $data = $this->dataObjectProcessor->buildOutputDataArray($product, ProductInterface::class);
        // the model property is required for some core entities (otherwise some properties, like id, cannot be accessed)
        $data['model'] = $product instanceof ProductOrmModel ? $product : $this->createNewProductOrmModel($data);
        return $data;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $this->searchCriteriaBuilder->addFilter('name', chr(rand(97, 122)) . '%', 'like');
        $this->searchCriteriaBuilder->setPageSize(5);
        $result = $this->productRepository->getList($this->searchCriteriaBuilder->create());
        $products = $result->getItems();

        return values(map([$this, 'productDtoToArray'], $products));
    }
}
