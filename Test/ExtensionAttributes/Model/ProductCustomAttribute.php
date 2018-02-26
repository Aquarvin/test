<?php

namespace Test\ExtensionAttributes\Model;

use Magento\Framework\Model\AbstractModel;
use Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface;

class ProductCustomAttribute extends AbstractModel implements ProductCustomAttributeInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\ProductCustomAttribute::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomProductNote()
    {
        return $this->getData(self::CUSTOM_PRODUCT_NOTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomProductNote($customProductNote)
    {
        return $this->setData(self::CUSTOM_PRODUCT_NOTE, $customProductNote);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

}