<?php

namespace Test\SendMailPreference\Model;

interface MailCountInterface
{
    /**
     * Get EmailCounter by Order Id.
     *
     * @param string $orderId
     *
     * @return null|\Test\SendMailPreference\Model\MailCount
     */
    public function getEmailCounterByOrderId($orderId);
}