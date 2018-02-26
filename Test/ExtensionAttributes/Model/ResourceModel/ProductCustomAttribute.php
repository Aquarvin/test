<?php

namespace Test\ExtensionAttributes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductCustomAttribute extends AbstractDb
{
    public function _construct()
    {
        $this->_init('test_extension_attributes', 'entity_id');
    }

    public function getByProductId($productId)
    {
        $connection = $this->getConnection();
        $select = $connection
            ->select()
            ->from($this->getMainTable())
            ->where('product_id = ?', $productId);
        return $connection->fetchRow($select);
    }
}