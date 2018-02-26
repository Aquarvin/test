<?php

namespace Test\SendMailPreference\Test\Unit\Model;

use Test\SendMailPreference\Model\MailCount;

class MailCountTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  Test for getEmailCounterByOrderId()
     */
    public function testGetEmailCounterByOrderId()
    {
        $orderId = '1';

        /** @var \Magento\Sales\Model\Order|\PHPUnit_Framework_MockObject_MockObject $order */
        $order = $this->getMockBuilder('Magento\Sales\Model\Order')
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Magento\Framework\Model\Context|\PHPUnit_Framework_MockObject_MockObject $contextMock */
        $contextMock = $this->getMockBuilder('Magento\Framework\Model\Context')
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Magento\Framework\Registry|\PHPUnit_Framework_MockObject_MockObject $registryMock */
        $registryMock = $this->getMockBuilder('Magento\Framework\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Magento\Framework\Model\ResourceModel\AbstractResource|\PHPUnit_Framework_MockObject_MockObject $resourceMock */
        $resourceMock = $this->getMockBuilder('Magento\Framework\Model\ResourceModel\AbstractResource')
            ->setMethods(['getIdFieldName'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        /** @var \Magento\Framework\Data\Collection\AbstractDb|\PHPUnit_Framework_MockObject_MockObject $resourceCollectionMock */
        $resourceCollectionMock = $this->getMockBuilder('Magento\Framework\Data\Collection\AbstractDb')
            ->disableOriginalConstructor()
            ->getMock();

        $resourceCollectionMock->expects($this->once())
            ->method('addFieldToFilter')
            ->with($this->equalTo('order_id'), $orderId)
            ->will($this->returnSelf());

        $resourceCollectionMock->expects($this->once())
            ->method('getFirstItem')
            ->will($this->returnValue($order));

        $result = (new MailCount(
            $contextMock,
            $registryMock,
            $resourceMock,
            $resourceCollectionMock
        ))->getEmailCounterByOrderId($orderId);

        $this->assertEquals($result, $order);
    }
}
