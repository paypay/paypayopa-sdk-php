<?php

use PayPay\OpenPaymentAPI\Controller\ClientControllerException;

require_once('TestBoilerplate.php');
final class WalletTest extends TestBoilerplate
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
     * Wallet balance test
     *
     * @return void
     */
    public function testWalletBalance()
    {
        $resp = $this->client->wallet->checkWalletBalance($this->config['uaid'], 1, 'JPY');
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
    public function testWalletBalanceWProductType()
    {
        $resp = $this->client->wallet->checkWalletBalance($this->config['uaid'], 1, 'JPY',"VIRTUAL_BONUS_INVESTMENT");
        $resultInfo = $resp['resultInfo'];
        $this->assertEquals('SUCCESS', $resultInfo['code']);
    }
    public function testWalletBalanceWrongProduct()
    {
        try {
            //code...
            $resp = $this->client->wallet->checkWalletBalance($this->config['uaid'], 1, 'JPY',"SnakeOil");
        } catch (ClientControllerException $e) {
            $this->assertStringContainsString("Invalid Direct Debit Product Type",$e->getMessage());
            //throw $th;
        }
        
    }
}
