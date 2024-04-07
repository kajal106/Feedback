<?php
namespace Kajal\Feedback\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

class Form extends Template
{
    protected $productRepository;
    protected $searchCriteriaBuilder;

    public function __construct(
        Template\Context $context,
        ProductCollectionFactory $productCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_logger = $logger;
        parent::__construct($context, $data);
    }
    public function getProducts()
    {
        $products = [];
        try {
            $collection = $this->productCollectionFactory->create()
                ->addAttributeToSelect('*')
                ->load();
            foreach ($collection as $product) {
                $products[] = [
                    'value' => $product->getEntityId(),
                    'label' => $product->getName()
                ];
            }
        } catch (\Exception $e) {
            $this->_logger->error($e->getMessage());
        }
        return $products;
    }
}
