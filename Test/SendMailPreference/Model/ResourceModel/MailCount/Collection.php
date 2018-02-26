<?php

namespace Test\SendMailPreference\Model\ResourceModel\MailCount;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            'Test\SendMailPreference\Model\MailCount',
            'Test\SendMailPreference\Model\ResourceModel\MailCount'
        );
    }
}