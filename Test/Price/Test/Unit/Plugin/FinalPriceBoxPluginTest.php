<?php

namespace Test\Price\Test\Unit\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Test\Price\Plugin\FinalPriceBoxPlugin;

class FinalPriceBoxPluginTest extends \PHPUnit_Framework_TestCase
{
    /** @var Customer|\PHPUnit_Framework_MockObject_MockObject */
    private $customer;

    /** @var Session|\PHPUnit_Framework_MockObject_MockObject */
    private $session;

    /** @var SessionFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $sessionFactory;

    /** @var FinalPriceBox|\PHPUnit_Framework_MockObject_MockObject */
    private $subject;

    /**
     * Set up function
     */
    protected function setUp()
    {
        $this->customer = $this->getMockBuilder('Magento\Customer\Model\Customer')
            ->disableOriginalConstructor()
            ->getMock();
        $this->session = $this->getMockBuilder('Magento\Customer\Model\Session')
            ->disableOriginalConstructor()
            ->getMock();
        $this->sessionFactory = $this->getMockBuilder('Magento\Customer\Model\SessionFactory')
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->subject = $this->getMockBuilder('Magento\Catalog\Pricing\Render\FinalPriceBox')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test for AfterToHtml plugin for logged/not logged in users
     *
     * @param $expected
     * @param $customerId
     *
     * @dataProvider afterToHtmlProvider
     */
    public function testAfterToHtml($expected, $customerId)
    {
        $this->customer->expects($this->once())
            ->method('getId')
            ->willReturn($customerId);

        $this->session->expects($this->once())
            ->method('getCustomer')
            ->will($this->returnValue($this->customer));

        $this->sessionFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->session));

        $result = (new FinalPriceBoxPlugin(
            $this->sessionFactory
        ))->afterToHtml(
            $this->subject,
            $expected
        );
        $this->assertEquals($expected, $result);
    }

    public function afterToHtmlProvider()
    {
        return [
            ['some price', 12],
            ['', null],
        ];
    }
}
