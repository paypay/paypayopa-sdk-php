<?php

use PayPay\OpenPaymentAPI\Models\CashBackPayload;

require_once('TestBoilerplate.php');
final class CashbackTest extends BoilerplateTest
{
    /**
     * Give cashback
     *
     * @return void
     */
    public function GiveCashBack($similar=false)
    {
        $this->InitCheck();
        $client = $this->client;
        $merchatCashbackId = uniqid('TESTUSER');
        $amount = [
            "amount" => 1, // $similar?12:rand(5, 10),
            "currency" => "JPY"
        ];
        $CPPayload = new CashBackPayload();
        $CPPayload->setMerchantCashbackId($merchatCashbackId)->setRequestedAt()->setUserAuthorizationId($this->config['uaid'])->setAmount($amount);
        var_dump('resp 1: ', $merchatCashbackId);
        $resp = $client->cashback->giveCashback($CPPayload, $similar);
        var_dump('resp: ', $merchatCashbackId);
        var_dump($resp);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
    }

    /**
     * CheckCashBackDetails
     *
     * @return void
     */
    public function CheckCashBackDetails()
    {
        $merchatCashbackId ='TESTUSER60139c565afec'; // $this->data['merchantRefundId'];
        $resp = $this->client->cashback->getCashbackDetails($merchatCashbackId);
        var_dump('resp: ', $merchatCashbackId);
        var_dump($resp);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }

    /**
    * Give ReversalCashBack
    *
    * @return void
    */
    public function ReversalCashBack($similar=false)
    {
        $client = $this->client;
        $merchantCashbackReversalId = uniqid('TESTUSER');
        $merchatCashbackId = 'TESTUSER60139c565afec'; // uniqid('TESTUSER');
        $amount = [
            "amount" => 1, // $similar?12:rand(5, 10),
            "currency" => "JPY"
        ];
        $CPPayload = new CashBackPayload();
        $CPPayload->setMerchantCashbackReversalId($merchantCashbackReversalId)->setMerchantCashbackId($merchatCashbackId)->setRequestedAt()->setUserAuthorizationId($this->config['uaid'])->setAmount($amount);
        // Get data for QR code
        $resp = $client->cashback->reverseCashBack($CPPayload, $similar);
        var_dump('resp: ', $merchatCashbackId, $merchantCashbackReversalId);
        var_dump($resp);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
    }

    /**
     * CheckCashBackDetails
     *
     * @return void
     */
    public function CheckReversalCashBackDetails()
    {
        $merchantCashbackReversalId = uniqid('TESTUSER');
        $merchatCashbackId = uniqid('TESTUSER');
        $resp = $this->client->cashback->getReversalCashbackDetails($merchantCashbackReversalId, $merchatCashbackId);
        var_dump('resp: ', $merchantCashbackReversalId, $merchatCashbackId);
        var_dump($resp);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
    
    /**
     * tests Create And Cancel
     *
     * @return void
     */
    public function testCreateAndCancel()
    {
        $this->GiveCashBack();
        // $this->CheckCashBackDetails();
        // $this->ReversalCashBack();
        // $this->CheckReversalCashBackDetails();
    }
}