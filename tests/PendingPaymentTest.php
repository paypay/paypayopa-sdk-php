<?php

use PayPay\OpenPaymentAPI\Models\CreateContinuousPaymentPayload;
use PayPay\OpenPaymentAPI\Models\CreatePendingPaymentPayload;
use PayPay\OpenPaymentAPI\Models\ModelException;
use PayPay\OpenPaymentAPI\Models\RefundPaymentPayload;

require_once 'TestBoilerplate.php' ;
final class PendingPaymentTest extends BoilerplateTest
{
    /**
     * Create pending payment
     *
     * @return void
     */
    public function Create()
    {
        $this->InitCheck();
        $client = $this->client;
        $CPPPayload = new CreatePendingPaymentPayload();
        // Save Cart totals
        $amount = [
            "amount" => rand(5, 20),
            "currency" => "JPY"
        ];
        
        $CPPPayload
            ->setMerchantPaymentId(uniqid('TESTMERCH_PAY_ID'))
            ->setRequestedAt()
            ->setUserAuthorizationId($this->config['uaid'])
            ->setAmount($amount);
        // Get data for QR code
        $resp = $client->payment->createPendingPayment($CPPPayload);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
        $data = $resp['data'];
        $this->data = $data;
        $this->assertNotNull($data, 'Empty data returned');
    }
    /**
     * Pending payment details
     *
     * @return void
     */
    public function Details()
    {
        $client = $this->client;
        $data =  $this->data;
        $merchantPaymentId = $data['merchantPaymentId'];
        $this->assertTrue(isset($merchantPaymentId), 'Merchant Payment ID not set');
        $paymentDetails = $client->payment->getPaymentDetails($merchantPaymentId, 'pending');
        $this->data=$paymentDetails["data"];
        $this->assertEquals('SUCCESS', $paymentDetails['resultInfo']['code']);
        
        echo'\n===================Pending Payment Details===================\n';
    }
    /**
     * Cancel pending payment
     *
     * @return void
     */
    public function Cancel()
    {
        $data =  $this->data;
        $merchantPaymentId = $data['merchantPaymentId'];
        $this->assertTrue(isset($merchantPaymentId), 'Merchant Payment ID not set');
        $resp = $this->client->payment->cancelPayment($merchantPaymentId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
    }

    /**
     * tests Create And Cancel
     *
     * @return void
     */
    public function testCreateAndCancel()
    {
        $this->Create();
        $this->Details();
        $this->Cancel();
    }
    /**
     * Refund
     *
     * @return void
     */
    public function refund()
    {
        $data = $this->data;
        $paymentId = $data['paymentId'];
        $refundId = uniqid('TESTREFUND');
        // Save Cart totals
        $amount = [
            "amount" => 2,
            "currency" => "JPY"
        ];
        $RPPayload = new RefundPaymentPayload();
        $RPPayload
            ->setMerchantRefundId($refundId)
            ->setPaymentId($paymentId)
            ->setAmount($amount)
            ->setRequestedAt();
        $resp = $this->client->refund->refundPayment($RPPayload, 'pending');
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals("SUCCESS", $resultInfo['code']);
        $this->data = $resp['data'];
    }
    /**
     * Refund Details
     *
     * @return void
     */
    public function refundDetails()
    {
        $merchantRefundId = $this->data['merchantRefundId'];
        $resp = $this->client->refund->getRefundDetails($merchantRefundId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
    public function testRefund()
    {
        $this->Create(true);
        $this->Details();
        $this->refund();
        $this->refundDetails();
    }
    public function testBadPayloadFailure()
    {
        try {
            $this->client->payment->createPendingPayment(2);
        } catch (ModelException $e) {
            $this->assertStringContainsString("Payload not of type CreatePendingPaymentPayload", $e->getMessage());
        }
    }
}