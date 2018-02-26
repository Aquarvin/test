<?php

namespace Test\ExtensionAttributes\Plugin;

use Magento\Catalog\Controller\Adminhtml\Product\Builder;
use Test\ExtensionAttributes\Api\ProductCustomAttributeRepositoryInterface;
//use Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface;
use Test\ExtensionAttributes\Model\ProductCustomAttributeFactory;

class ProductGet
{
    protected $productCustomAttributeRepository;
    protected $productCustomAttribute;
    protected $productExtensionFactory;
    protected $productFactory;


    public function __construct(
        ProductCustomAttributeRepositoryInterface $productCustomAttributeRepositoryInterface,
        ProductCustomAttributeFactory $productCustomAttributeFactory,
        \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory
    )
    {
        $this->productCustomAttributeRepository = $productCustomAttributeRepositoryInterface;
        $this->productCustomAttribute = $productCustomAttributeFactory;
        $this->productFactory = $productFactory;
        $this->productExtensionFactory = $productExtensionFactory;
    }

    public function afterBuild(
        \Magento\Catalog\Controller\Adminhtml\Product\Builder $subject,
        \Magento\Catalog\Api\Data\ProductInterface $resultProduct
    ) {
        $resultProduct = $this->getProductCustomAttribute($resultProduct);

        return $resultProduct;
    }

    private function getProductCustomAttribute(\Magento\Catalog\Api\Data\ProductInterface $product)
    {

        try {
            /** @var bool|\Test\ExtensionAttributes\Model\ProductCustomAttribute $productCustomAttribute */
            $productCustomAttributeData = $this->productCustomAttributeRepository->getByProductId($product->getEntityId());
        } catch (NoSuchEntityException $e) {
            return $product;
        }

        /** @var  \Magento\Catalog\Api\Data\ProductExtension $extensionAttributes */
        $extensionAttributes = $product->getExtensionAttributes();
        $productExtension = $extensionAttributes ? $extensionAttributes : $this->productExtensionFactory->create();

        /** @var \Test\ExtensionAttributes\Model\ProductCustomAttribute $productCustomAttribute */
        $productExtension->setProductCustomExtensionAttribute($productCustomAttributeData);
        $product->setExtensionAttributes($productExtension);
//        $product->setCustomProductNote($productCustomAttributeData->getCustomProductNote());

        return $product;
    }
}
