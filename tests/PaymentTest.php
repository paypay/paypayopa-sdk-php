<?php

use PayPay\OpenPaymentAPI\Models\CreatePaymentPayload;

require_once('TestBoilerplate.php');
final class PaymentTest extends TestBoilerplate
{
    /**
     * Create direct debit payment
     *
     * @return void
     */
    public function Create($similar=false)
    {
        $client = $this->client;
        $CPPayload = new CreatePaymentPayload();
        // Save Cart totals
        $amount = [
            "amount" => $similar?12:rand(5,10),
            "currency" => "JPY"
        ];
        $CPPayload->setMerchantPaymentId(uniqid('TESTMERCH_PAY_ID'))->setRequestedAt()->setUserAuthorizationId($this->config['uaid'])->setAmount($amount);
        // Get data for QR code
        $resp = $client->payment->createPayment($CPPayload,$similar);
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
        $this->Cancel();
        $this->Create(true);
        $this->Cancel();
    }
}
