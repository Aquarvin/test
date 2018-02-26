<?php

namespace Test\SendMailPreference\Block\Adminhtml\Order;

use Test\SendMailPreference\Model\MailCountFactory;

class View extends \Magento\Sales\Block\Adminhtml\Order\View
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * Sales config
     *
     * @var \Magento\Sales\Model\Config
     */
    protected $_salesConfig;

    /**
     * Reorder helper
     *
     * @var \Magento\Sales\Helper\Reorder
     */
    protected $_reorderHelper;

    /**
     * @var \Test\SendMailPreference\Model\MailCountFactory
     */
    protected $mailCountFactory;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param \Magento\Sales\Model\Config           $salesConfig
     * @param \Magento\Sales\Helper\Reorder         $reorderHelper
     * @param MailCountFactory                      $mailCountFactory
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\Config $salesConfig,
        \Magento\Sales\Helper\Reorder $reorderHelper,
        MailCountFactory $mailCountFactory,
        array $data = []
    ) {
        $this->mailCountFactory = $mailCountFactory;
        parent::__construct($context, $registry, $salesConfig, $reorderHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();

        $order = $this->getOrder();

        if (!$order) {
            return;
        }
        $sendMailCount = '';

        /** @var \Test\SendMailPreference\Model\MailCount $mailCount */
        $mailCount = $this->mailCountFactory->create();
        $mailCount = $mailCount->getEmailCounterByOrderId($order->getId());
        if ($mailCount && $mailCount->getId()) {
            $sendMailCount = ' ' . $mailCount->getSendmailCount();
        }

        if ($this->_isAllowedAction('Magento_Sales::emails') && !$order->isCanceled()) {
            $message = __('Are you sure you want to send an order email to customer?');
            $this->addButton(
                'send_notification',
                [
                    'label'   => __('Send Email' . $sendMailCount),
                    'class'   => 'send-email',
                    'onclick' => "confirmSetLocation('{$message}', '{$this->getEmailUrl()}')",
                ]
            );
        }
    }
}