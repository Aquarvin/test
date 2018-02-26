<?php

namespace Test\SendMailPreference\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MailCount extends AbstractDb
{
    public function _construct()
    {
        $this->_init('test_sendmail', 'entity_id');
    }
}