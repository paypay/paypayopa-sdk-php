<?php

use PayPay\OpenPaymentAPI\Models\CapturePaymentAuthPayload;
use PayPay\OpenPaymentAPI\Models\CreatePaymentAuthPayload;
use PayPay\OpenPaymentAPI\Models\RevertAuthPayload;

require_once('TestBoilerplate.php');

class PreAuthTest extends TestBoilerplate
{
    

    public function Create()
    {
        $CPApayload = new CreatePaymentAuthPayload();
        $CPApayload->setMerchantPaymentId(uniqid('TEST_PREAUTH'))
            ->setUserAuthorizationId($this->config['uaid'])
            ->setAmount(['amount' => 20, 'currency' => 'JPY'])
            ->setRequestedAt();
        $resp = $this->client->payment->createPaymentAuth($CPApayload, true);
        var_dump($resp);
        $this->assertTrue(isset($resp['resultInfo']));
        $this->assertEquals('SUCCESS', $resp['resultInfo']['code'], $resp['resultInfo']['message'] . ':' . $resp['transit'][4]);
        $this->data = $resp['data'];
    }
    /**
     * Capture Auth
     *
     * @return void
     */
    public function CaptureAuthorization()
    {
        $client = $this->client;
        $mpayID = $this->data["merchantPaymentId"];
        $CAPayload = new CapturePaymentAuthPayload();
        // Save Cart totals
        $amount = [
            "amount" => 20,
            "currency" => "JPY"
        ];
        $CAPayload
            ->setMerchantPaymentId($mpayID)
            ->setAmount($amount)
            ->setMerchantCaptureId(uniqid('TESTMERCH_CAP_ID'))
            ->setRequestedAt()
            ->setOrderDescription(uniqid('TESTMERCH_CAP_ID'));
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
        $this->assertEquals('SUCCESS', $resultInfo['code'],$resultInfo['code'].":".$resp["transit"][4]);
    }
    /**
     * tests Capture
     *
     * @return void
     */
    public function testPreauthCapture()
    {
        $this->Create();
        $this->CaptureAuthorization();
    }
    /**
     * tests  Revert
     *
     * @return void
     */
    public function testPreauthRevert()
    {
        $this->Create();
        $this->RevertAuthorization();
    }
}
