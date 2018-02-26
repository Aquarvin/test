<?php

namespace Test\Price\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox;
use Magento\Customer\Model\SessionFactory;

class FinalPriceBoxPlugin
{
    /** @var SessionFactory */
    private $sessionFactory;

    /**
     * @param SessionFactory $sessionFactory
     */
    public function __construct(
        SessionFactory $sessionFactory
    ) {
        $this->sessionFactory = $sessionFactory;
    }

    /**
     * For not authorized customer return empty string
     *
     * @param FinalPriceBox $subject
     * @param string $result
     * @return string
     */
    public function afterToHtml(
        FinalPriceBox $subject,
        $result
    ) {
        /** @var $session \Magento\Customer\Model\Session */
        $session = $this->sessionFactory->create();
        if (!$session->getCustomer()->getId()) {
            $result = '';
        }

        return $result;
    }
}
