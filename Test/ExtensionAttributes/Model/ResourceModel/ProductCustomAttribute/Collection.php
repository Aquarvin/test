<?php

namespace Test\ExtensionAttributes\Model\ResourceModel\ProductCustomAttribute;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            'Test\ExtensionAttribute\Model\ProductCustomAttribute',
            'Test\ExtensionAttribute\Model\ResourceModel\ProductCustomAttribute'
        );
    }
}