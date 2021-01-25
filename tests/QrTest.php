<?php

use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\OrderItem;

require_once('TestBoilerplate.php');
final class QrTest extends BoilerplateTest
{
    /**
     * Creates QR
     *
     * @return void
     */
    public function Create()
    {
        $this->InitCheck();
        $client = $this->client;
        $CQCPayload = new CreateQrCodePayload();
        $OrderItems = [];
        $OrderItems[] = (new OrderItem())
            ->setName('Cake')
            ->setQuantity(1)
            ->setUnitPrice(['amount' => 20, 'currency' => 'JPY']);
        $CQCPayload
            ->setMerchantPaymentId(uniqid('Test123'))
            ->setAmount(['amount' => 20, 'currency' => 'JPY'])
            ->setCodeType()
            ->setOrderItems($OrderItems);

        // Get data for QR code
        $resp = $client->code->createQRCode($CQCPayload);
        var_dump($resp);
        $payDeets = $client->code->getPaymentDetails($CQCPayload->getMerchantPaymentId());
        print_r('\n===================Details===================\n');
        var_dump($payDeets);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);

        $data = $resp['data'];
        $this->data = $data;
        $this->assertNotNull($data, 'Empty data returned');
    }
    /**
     * Delete
     *
     * @return void
     */
    public function Delete()
    {
        $data =  $this->data;
        $codeId = $data['codeId'];
        $this->assertTrue(isset($codeId), 'Code ID not set');
        ;
        $resp = $this->client->code->deleteQRCode($codeId);
        var_dump($resp);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
    /**
     * Cancel Payment
     *
     * @return void
     */
    public function Cancel()
    {
        $data =  $this->data;
        $merchantPaymentId = $data['merchantPaymentId'];
        $this->assertTrue(isset($merchantPaymentId), 'Code ID not set');
        ;
        $resp = $this->client->payment->cancelPayment($merchantPaymentId);
        var_dump($resp);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
    }
    /**
     * tests Create And Delete
     *
     * @return void
     */
    public function testCreateAndDelete()
    {
        $this->Create();
        $this->Delete();
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