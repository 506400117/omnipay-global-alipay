<?php

namespace Omnipay\GlobalAlipay;

use Omnipay\GlobalAlipay\Message\CompletePurchaseResponse;
use Omnipay\GlobalAlipay\Message\WebPurchaseResponse;
use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

class WapGatewayTest extends TestCase
{
    /**
     * @var WapGateway
     */
    protected $gateway;

    protected $options;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = Omnipay::create('GlobalAlipay_Wap');
        $this->gateway->setPartner('123456');
        $this->gateway->setKey('xxxxxxx');
        $this->gateway->setSignType('MD5');
        $this->gateway->setNotifyUrl('http://example.com/notify');
    }

    public function testPurchase()
    {
        $order = [
            'subject'      => 'test', //Your subject
            'out_trade_no' => date('YmdHis'), //trade no
            'total_fee'    => '0.01', //order fee
        ];

        /**
         * @var WebPurchaseResponse
         */
        $response = $this->gateway->purchase($order)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectData());
    }

    public function testCompletePurchase()
    {
        $options = [
            'request_params' => [
                'out_trade_no' => '123456',
                'sign'         => '123456',
                'sign_type'    => 'MD5',
            ],
        ];

        /**
         * @var CompletePurchaseResponse
         */
        $response = $this->gateway->completePurchase($options)->send();
        $this->assertFalse($response->isSuccessful());
    }
}
