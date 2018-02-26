<?php

namespace Test\ExtensionAttributes\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\ExtensionAttributes\Api\ProductCustomAttributeRepositoryInterface;
use Test\ExtensionAttributes\Model\ResourceModel\ProductCustomAttribute as ProductCustomAttributeResource;
use Test\ExtensionAttributes\Model\ResourceModel\ProductCustomAttribute\CollectionFactory;

class ProductCustomAttributeRepository implements ProductCustomAttributeRepositoryInterface
{
    /**
     * @var ProductCustomAttributeResource
     */
    private $productCustomAttributeResource;
    /**
     * @var ProductCustomAttributeFactory
     */
    private $productCustomAttributeFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        ProductCustomAttributeResource $productCustomAttributeResource,
        ProductCustomAttributeFactory $productCustomAttributeFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->productCustomAttributeResource = $productCustomAttributeResource;
        $this->productCustomAttributeFactory = $productCustomAttributeFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param \Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface $productCustomAttribute
     *
     * @return \Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface
     */
    public function save(\Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface $productCustomAttribute)
    {
        $this->productCustomAttributeResource->save($productCustomAttribute);

        return $productCustomAttribute;
    }

    /**
     * @param int $productCustomAttributeId
     *
     * @return \Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($productCustomAttributeId)
    {
        $productCustomAttribute = $this->productCustomAttributeFactory->create();
        $this->productCustomAttributeResource->load($productCustomAttribute, $productCustomAttributeId);
        if (!$productCustomAttribute->getId()) {
            throw new NoSuchEntityException('Custom Extension Attribute does not exist');
        }

        return $productCustomAttribute;
    }

    /**
     * @param int $productId
     *
     * @return bool|\Test\ExtensionAttributes\Model\ProductCustomAttribute
     * @throws NoSuchEntityException
     */
    public function getByProductId($productId)
    {
        /** @var array|bool $productData */
        $productData = $this->productCustomAttributeResource->getByProductId($productId);
        /** @var bool|\Test\ExtensionAttributes\Model\ProductCustomAttribute $productCustomAttribute */
        $productCustomAttribute = $productData ? $this->getById($productData['entity_id']) : $productData;

        return $productCustomAttribute;
    }

    /**
     * @param int $productCustomAttributeId
     *
     * @return bool
     */
    public function delete($productCustomAttributeId)
    {
        $productCustomAttribute = $this->productCustomAttributeFactory->create();
        $productCustomAttribute->setId($productCustomAttributeId);
        if ($this->productCustomAttributeResource->delete($productCustomAttribute)) {
            return true;
        } else {
            return false;
        }
    }
}