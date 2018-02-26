<?php

namespace Test\SendMail\Plugin;

use Magento\Backend\Block\Widget\Container;

class ContainerPlugin
{
    /**
     * Add suffix to Send email button.
     *
     * @param Container $container
     * @param string    $buttonId
     * @param array     $data
     * @param int       $level
     * @param int       $sortOrder
     * @param string    $region
     *
     * @return array
     */
    public function beforeAddButton(
        Container $container,
        $buttonId,
        $data,
        $level = 0,
        $sortOrder = 0,
        $region = 'toolbar'
    ) {
        if ($container instanceof \Magento\Sales\Block\Adminhtml\Order\View
            && $buttonId == 'send_notification'
        ) {
            $suffix = $container->getOrder()->getEmailSent() === '1' ? '(True)'
                : '(False)';
            $data['label'] .= " $suffix";
        }

        return [$buttonId, $data, $level, $sortOrder, $region];
    }
}
