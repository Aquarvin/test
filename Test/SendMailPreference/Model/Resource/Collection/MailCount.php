<?php

namespace Test\SendMailPreference\Model\Resource\Collection;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Test\SendMailPreference\Model\MailCount',
            'Test\SendMailPreference\Model\Resource\MailCount'
        );
    }
}