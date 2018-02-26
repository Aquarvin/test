<?php

namespace Test\ExtensionAttributes\Plugin;

use Test\ExtensionAttributes\Model\ProductCustomAttributeFactory;
use Test\ExtensionAttributes\Api\ProductCustomAttributeRepositoryInterface;


class ProductSave
{
    protected $productCustomAttribute;

    protected $productCustomAttributeRepository;


    public function __construct(
        ProductCustomAttributeFactory $productCustomAttributeFactory,
        ProductCustomAttributeRepositoryInterface $productCustomAttributeRepositoryInterface
    ) {
        $this->productCustomAttribute = $productCustomAttributeFactory;
        $this->productCustomAttributeRepository = $productCustomAttributeRepositoryInterface;
    }

    public function afterSave(
        \Magento\Catalog\Model\Product $subject,
        \Magento\Catalog\Model\Product $resultProduct
    ) {
        $resultProduct = $this->saveProductCustomExtensionAttribute($resultProduct);

        return $resultProduct;
    }

    private function saveProductCustomExtensionAttribute(\Magento\Catalog\Model\Product $product)
    {
        $extensionAttributes = $product->getExtensionAttributes();
        if (
            null !== $extensionAttributes
            && null !== $extensionAttributes->getProductCustomExtensionAttribute()
        ) {
            $productCustomExtensionAttribute = $extensionAttributes->getProductCustomExtensionAttribute();
            try {
                if ($productCustomExtensionAttribute && $productCustomExtensionAttribute->getEntityId()){
                    $productCustomAttributeModel = $this->productCustomAttributeRepository->getById($productCustomExtensionAttribute->getEntityId());
                }  else {
                    $productCustomAttributeModel = $this->productCustomAttribute->create();
                }

                $productCustomAttributeModel->setProductId($product->getEntityId());
                $productCustomAttributeModel->setCustomProductNote($product->getCustomProductNote());
                $this->productCustomAttributeRepository->save($productCustomAttributeModel);
            } catch (\Exception $e) {
                throw new CouldNotSaveException(
                    __('Could not add attribute to product: "%1"', $e->getMessage()),
                    $e
                );
            }
        }

        return $product;
    }
}
