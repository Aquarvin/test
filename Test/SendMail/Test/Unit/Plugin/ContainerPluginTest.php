<?php

namespace Test\SendMail\Test\Unit\Plugin;

use Test\SendMail\Plugin\ContainerPlugin;

class ContainerPluginTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Magento\Sales\Model\Order|\PHPUnit_Framework_MockObject_MockObject */
    private $order;

    /** @var \Magento\Sales\Block\Adminhtml\Order\View|\PHPUnit_Framework_MockObject_MockObject */
    private $container;

    /**
     * Set up function
     */
    protected function setUp()
    {
        $this->order = $this->getMockBuilder('Magento\Sales\Model\Order')
            ->disableOriginalConstructor()
            ->getMock();

        $this->container = $this->getMockBuilder('Magento\Sales\Block\Adminhtml\Order\View')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test for BeforeAddButton plugin
     *
     * @param array  $expectedData
     * @param string $emailSent
     * @param array  $data
     *
     * @dataProvider beforeAddButtonProvider
     */
    public function testBeforeAddButton($expectedData, $emailSent, $data)
    {
        $this->order->expects($this->once())
            ->method('getEmailSent')
            ->willReturn((string)$emailSent);

        $this->container->expects($this->once())
            ->method('getOrder')
            ->will($this->returnValue($this->order));

        $result = (new ContainerPlugin())
            ->beforeAddButton(
                $this->container,
                $data['buttonId'],
                $data['data'],
                $data['level'],
                $data['sortOrder'],
                $data['region']
            );
        $this->assertEquals($expectedData['label'], $result[1]['label']);
    }

    public function beforeAddButtonProvider()
    {
        return [
            [
                ['label' => 'Send Mail(True)'],
                '1',
                [
                    'buttonId'  => 'send_notification',
                    'data'      => ['label' => 'Send Mail'],
                    'level'     => 0,
                    'sortOrder' => 0,
                    'region'    => 'toolbar',
                ],
            ],
            [
                ['label' => 'Send Mail(False)'],
                '0',
                [
                    'buttonId'  => 'send_notification',
                    'data'      => ['label' => 'Send Mail'],
                    'level'     => 0,
                    'sortOrder' => 0,
                    'region'    => 'toolbar',
                ],
            ],
        ];
    }
}
