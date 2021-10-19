<?php

use PayPay\OpenPaymentAPI\Models\CashBackPayload;
use PayPay\OpenPaymentAPI\Models\ReverseCashBackPayload;

require_once('TestBoilerplate.php');
final class CashbackTest extends BoilerplateTest
{
    /**
     * Tests giveCashback
     *
     * @return void
     */
    public function testGiveCashBack()
    {
        $this->InitCheck();
        $client = $this->client;
        $merchantCashbackId = "testXXXXXXXXXXXXXXX123";
        $amount = [
            "amount" => 1,
            "currency" => "JPY"
        ];
        $CPPayload = new CashBackPayload();
        $CPPayload->setMerchantCashbackId($merchantCashbackId)->setRequestedAt()->setUserAuthorizationId($this->config['uaid'])->setAmount($amount);
        $resp = $client->cashback->giveCashback($CPPayload);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
        $tempMerchantCashbackId = $merchantCashbackId;
        $this->data = $tempMerchantCashbackId;
    }

    /**
     * Tests getCashbackDetails when code is SUCCESS
     *
     * @return void
     */
    public function testCheckCashBackDetailsSuccess()
    {
        $merchantCashbackId = "test-success";
        $resp = $this->client->cashback->getCashbackDetails($merchantCashbackId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
        $this->assertEquals('00000000000000001111', $resp['data']['cashbackId']);
        $this->assertEquals(1, $resp['data']['amount']['amount']);
    }

    /**
     * Tests getCashbackDetails when code is NOT_ENOUGH_MONEY
     *
     * @return void
     */
    public function testCheckCashBackDetailsNotEnoughMoney()
    {
        $merchantCashbackId = "test-not-enough-money";
        $resp = $this->client->cashback->getCashbackDetails($merchantCashbackId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('NOT_ENOUGH_MONEY', $resultInfo['code']);
        $this->assertEquals('00000000000000009999', $resp['data']['cashbackId']);
        $this->assertEquals(100000, $resp['data']['amount']['amount']);
    }

    /**
    * Tests reverseCashBack
    *
    * @return void
    */
    public function testReversalCashBack()
    {
        $client = $this->client;
        $merchantCashbackReversalId = "TESTXXXXXXXXX456";
        $merchantCashbackId = "testXXXXXXXXXXXXXXX123";
        $reason = "reason";
        $amount = [
            "amount" => 1,
            "currency" => "JPY"
        ];
        $CPPayload = new ReverseCashBackPayload();
        $CPPayload->setMerchantCashbackReversalId($merchantCashbackReversalId)->setMerchantCashbackId($merchantCashbackId)->setRequestedAt()->setReason($reason)->setAmount($amount);
        $resp = $client->cashback->reverseCashBack($CPPayload);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
    }

    /**
     * Tests giveReversalCashbackDetails
     *
     * @return void
     */
    public function testCheckReversalCashBackDetails()
    {
        $merchantCashbackReversalId = "TESTXXXXXXXXX456";
        $merchantCashbackId = "testXXXXXXXXXXXXXXX123";
        $resp = $this->client->cashback->getReversalCashbackDetails($merchantCashbackReversalId, $merchantCashbackId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
}