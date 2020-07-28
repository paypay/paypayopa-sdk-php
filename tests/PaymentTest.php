<?php

use PayPay\OpenPaymentAPI\Models\CapturePaymentAuthPayload;
use PayPay\OpenPaymentAPI\Models\CreatePaymentPayload;
use PayPay\OpenPaymentAPI\Models\RevertAuthPayload;

require_once('TestBoilerplate.php');
final class PaymentTest extends TestBoilerplate
{
    /**
     * Init check
     *
     * @return void
     */
    public function testInit()
    {
        $this->InitCheck();
    }
    /**
     * Create direct debit payment
     *
     * @return void
     */
    public function Create()
    {
        $client = $this->client;
        $CPPayload = new CreatePaymentPayload();
        // Save Cart totals
        $amount = [
            "amount" => 1,
            "currency" => "JPY"
        ];
        $CPPayload->setMerchantPaymentId(uniqid('TESTMERCH_PAY_ID'))->setRequestedAt()->setUserAuthorizationId($this->config['uaid'])->setAmount($amount);
        // Get data for QR code
        $resp = $client->payment->createPayment($CPPayload);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
        $data = $resp['data'];
        $this->data = $data;
        $this->assertNotNull($data, 'Empty data returned');
    }
    /**
     * Cancel DD payment
     *
     * @return void
     */
    public function Cancel()
    {
        $data =  $this->data;
        $merchantPaymentId = $data['merchantPaymentId'];
        $this->assertTrue(isset($merchantPaymentId), 'Merchant Payment ID not set');;
        $resp = $this->client->payment->cancelPayment($merchantPaymentId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
    }
    /**
     * tests DD Create
     *
     * @return void
     */
    public function testCreate()
    {
        $this->Create();
    }
    /**
     * tests Create And Cancel
     *
     * @return void
     */
    public function testCreateAndCancel()
    {
        $this->Create();
        $this->Cancel();
    }
    /**
     * Capture Auth
     *
     * @return void
     */
    public function CaptureAuthorization()
    {
        $client = $this->client;
        $CAPayload = new CapturePaymentAuthPayload();
        // Save Cart totals
        $amount = [
            "amount" => 1,
            "currency" => "JPY"
        ];
        $CAPayload->setMerchantPaymentId(uniqid('TESTMERCH_MERCPAY_ID'))->setAmount($amount)->setMerchantCaptureId(uniqid('TESTMERCH_CAP_ID'))->setRequestedAt()->setOrderDescription(uniqid('TESTMERCH_CAP_ID'));
        // Get data for QR code
        $resp = $client->payment->capturePaymentAuth($CAPayload);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
        $data = $resp['data'];
        $this->data = $data;
        $this->assertNotNull($data, 'Empty data returned');
    }
    /**
     * Revert Authorization
     *
     * @return void
     */
    public function RevertAuthorization()
    {
        $data =  $this->data;
        $paymentId = $data['paymentId'];
        $this->assertTrue(isset($paymentId), 'Payment ID not set');
        $RAPayload = new RevertAuthPayload();
        $RAPayload->setMerchantRevertId(uniqid('TESTMERCH_REV_ID'))->setPaymentId($paymentId)->setRequestedAt();
        $resp = $this->client->payment->revertAuth($RAPayload);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
    /**
     * tests Capture And Revert
     *
     * @return void
     */
    public function testCaptureAndRevert()
    {
        $this->CaptureAuthorization();
        $this->RevertAuthorization();
    }
}
