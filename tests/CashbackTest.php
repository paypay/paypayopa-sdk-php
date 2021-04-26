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
    public function GiveCashBack()
    {
        $this->InitCheck();
        $client = $this->client;
        $merchatCashbackId = "testXXXXXXXXXXXXXXX123";
        $amount = [
            "amount" => 1,
            "currency" => "JPY"
        ];
        $CPPayload = new CashBackPayload();
        $CPPayload->setMerchantCashbackId($merchatCashbackId)->setRequestedAt()->setUserAuthorizationId($this->config['uaid'])->setAmount($amount);
        $resp = $client->cashback->giveCashback($CPPayload);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('REQUEST_ACCEPTED', $resultInfo['code']);
        $tempMerchatCashbackId = $merchatCashbackId;
        $this->data = $tempMerchatCashbackId;
    }

    /**
     * CheckCashBackDetails
     *
     * @return void
     */
    public function CheckCashBackDetails()
    {
        $merchatCashbackId = "testXXXXXXXXXXXXXXX123";
        $resp = $this->client->cashback->getCashbackDetails($merchatCashbackId);
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }

    /**
    * Give ReversalCashBack
    *
    * @return void
    */
    public function ReversalCashBack()
    {
        $client = $this->client;
        $merchantCashbackReversalId = "TESTXXXXXXXXX456";
        $merchatCashbackId = "testXXXXXXXXXXXXXXX123";
        $reason = "reason";
        $amount = [
            "amount" => 1,
            "currency" => "JPY"
        ];
        $CPPayload = new ReverseCashBackPayload();
        $CPPayload->setMerchantCashbackReversalId($merchantCashbackReversalId)->setMerchantCashbackId($merchatCashbackId)->setRequestedAt()->setReason($reason)->setAmount($amount);
        $resp = $client->cashback->reverseCashBack($CPPayload);
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
        $merchantCashbackReversalId = "TESTXXXXXXXXX456";
        $merchatCashbackId = "testXXXXXXXXXXXXXXX123";
        $resp = $this->client->cashback->getReversalCashbackDetails($merchantCashbackReversalId, $merchatCashbackId);
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
        $this->CheckCashBackDetails();
        $this->ReversalCashBack();
        $this->CheckReversalCashBackDetails();
    }
}