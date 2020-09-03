<?php

use PayPay\OpenPaymentAPI\Models\CreateContinuousPaymentPayload;

require_once('TestBoilerplate.php');
final class ContinuousPaymentTest extends TestBoilerplate
{
    /**
     * Create direct debit payment
     *
     * @return void
     */
    public function Create()
    {
        $client = $this->client;
        $CCPPayload = new CreateContinuousPaymentPayload();
        // Save Cart totals
        $amount = [
            "amount" => 12,
            "currency" => "JPY"
        ];
        $CCPPayload->setMerchantPaymentId(uniqid('TESTMERCH_PAY_ID'))->setRequestedAt()->setUserAuthorizationId($this->config['uaid'])->setAmount($amount);
        // Get data for QR code
        $resp = $client->payment->createContinuousPayment($CCPPayload);
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
     * tests Create And Cancel
     *
     * @return void
     */
    public function testCreateAndCancel()
    {
        $this->Create();
        $this->Cancel();
    }
    
}
