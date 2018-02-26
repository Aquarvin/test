<?php

namespace Test\SendMailPreference\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;
use Test\SendMailPreference\Model\MailCountFactory;

class Email extends \Magento\Sales\Controller\Adminhtml\Order\Email
{
    /**
     * @var \Test\SendMailPreference\Model\MailCountFactory
     */
    protected $mailCountFactory;

    /**
     * @var \Test\SendMailPreference\Model\MailCountRepository
     */
    protected $mailCountRepository;

    /**
     * @param Action\Context                                       $context
     * @param \Magento\Framework\Registry                          $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory     $fileFactory
     * @param \Magento\Framework\Translate\InlineInterface         $translateInline
     * @param \Magento\Framework\View\Result\PageFactory           $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory     $resultJsonFactory
     * @param \Magento\Framework\View\Result\LayoutFactory         $resultLayoutFactory
     * @param \Magento\Framework\Controller\Result\RawFactory      $resultRawFactory
     * @param OrderManagementInterface                             $orderManagement
     * @param OrderRepositoryInterface                             $orderRepository
     * @param LoggerInterface                                      $logger
     * @param \Test\SendMailPreference\Model\MailCountFactory    $mailCountFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Translate\InlineInterface $translateInline,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        OrderManagementInterface $orderManagement,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger,
        MailCountFactory $mailCountFactory
    ) {
        $this->mailCountFactory = $mailCountFactory;
        parent::__construct(
            $context,
            $coreRegistry,
            $fileFactory,
            $translateInline,
            $resultPageFactory,
            $resultJsonFactory,
            $resultLayoutFactory,
            $resultRawFactory,
            $orderManagement,
            $orderRepository,
            $logger
        );
    }

    /**
     * Notify user
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $order = $this->_initOrder();
        if ($order) {
            try {
                $this->orderManagement->notify($order->getEntityId());
                $this->messageManager->addSuccess(__('You sent the order email.'));
                $this->countEmail($order);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(__('We can\'t send the email order right now.'));
                $this->logger->critical($e);
            }

            return $this->resultRedirectFactory->create()->setPath(
                'sales/order/view',
                [
                    'order_id' => $order->getEntityId(),
                ]
            );
        }

        return $this->resultRedirectFactory->create()->setPath('sales/*/');
    }

    /**
     * Counts sent emails for current order
     *
     * @param \Magento\Sales\Model\Order $order
     */
    protected function countEmail(\Magento\Sales\Model\Order $order)
    {
        /** @var \Test\SendMailPreference\Model\MailCount $mailCount */
        $mailCount = $this->mailCountFactory->create();
        $mailCount = $mailCount->getEmailCounterByOrderId($order->getId());
        if ($mailCount && $mailCount->getId()) {
            $mailCount->setSendmailCount($mailCount->getSendmailCount() + 1);
        } else {
            $mailCount->setOrderId($order->getId());
            $mailCount->setSendmailCount(1);
        }
        $mailCount->getResource()->save($mailCount);
    }
}
