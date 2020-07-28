<?php

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
}
