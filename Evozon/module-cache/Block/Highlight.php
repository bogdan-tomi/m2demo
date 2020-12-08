<?php declare(strict_types=1);

namespace Evozon\Cache\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;

class Highlight extends Template implements IdentityInterface
{

    private RequestInterface $request;

    private $highlightProduct;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(Context $context,
                                ProductRepository $productRepository,
                                RequestInterface $request,
                                array $data = [])
    {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->productRepository = $productRepository;
    }

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProduct()
    {
        if ($this->highlightProduct) {
            return $this->highlightProduct;
        }
        $this->highlightProduct = $this->productRepository->getById($this->request->getParam('id'));
        return $this->highlightProduct;
    }

    public function getIdentities()
    {
        return $this->getProduct()->getIdentities();
    }
}
