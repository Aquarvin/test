<?php

namespace Test\SendMailPreference\Model;

use Magento\Framework\Model\AbstractModel;

class MailCount extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Test\SendMailPreference\Model\ResourceModel\MailCount');
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailCounterByOrderId($orderId)
    {
        return $this->getCollection()
            ->addFieldToFilter('order_id', $orderId)
            ->getFirstItem();
    }
}