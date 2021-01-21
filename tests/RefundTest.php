<?php

use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\OrderItem;
use PayPay\OpenPaymentAPI\Models\RefundPaymentPayload;

require_once('TestBoilerplate.php');
final class RefundTest extends TestBoilerplate
{
    /**
     * Initialization check
     *
     * @return void
     */
    public function testInit()
    {
        $this->InitCheck();
    }
    /**
     * Create And Fetch Payment
     *
     * @return void
     */
    public function CreateAndFetchPayment()
    {
        $client = $this->client;
        $CQCPayload = new CreateQrCodePayload();
        $OrderItems = [];
        $OrderItems[] = (new OrderItem)->setName('Cake')->setQuantity(1)->setUnitPrice(['amount' => 20, 'currency' => 'JPY']);
        $CQCPayload->setMerchantPaymentId(uniqid('Test123'))->setAmount(['amount' => 20, 'currency' => 'JPY'])->setCodeType()->setOrderItems($OrderItems);

        // Get data for QR code
        $resp = $client->code->createQRCode($CQCPayload);
        var_dump($resp);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);

        $data = $resp['data'];
        $this->assertNotNull($data, 'Empty data returned');
        $detailResp = $client->payment->getPaymentDetails($CQCPayload->getMerchantPaymentId());
        $detailData = $detailResp['data'];
        $this->data = $detailData;
    }
    /**
     * Refund
     *
     * @return void
     */
    public function refund()
    {
        $data=$this->data;
        $paymentId = $data['paymentId'];
        $refundId = uniqid('TESTUSER');
        // Save Cart totals
        $amount = [
            "amount" => 1,
            "currency" => "JPY"
        ];
        $RPPayload = new RefundPaymentPayload();
        $RPPayload->setMerchantRefundId($refundId)->setPaymentId($paymentId)->setAmount($amount)->setRequestedAt();
        $resp = $this->client->refund->refundPayment($RPPayload);
        $resultInfo = $resp['resultInfo'];
        var_dump($resp);
        $this->assertEquals("SUCCESS", $resultInfo['code']);
        $this->data=$resp['data'];
    }
    /**
     * Refund Details
     *
     * @return void
     */
    public function refundDetails()
    {
        $merchantRefundId = $this->data['merchantRefundId'];
        ;
        $resp = $this->client->refund->getRefundDetails($merchantRefundId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
    /**
     * Tests Refund Flow
     *
     * @return void
     */
    public function testRefundFlow()
    {
        $this->CreateAndFetchPayment();
        $this->refund();
        $this->refundDetails();
    }
}