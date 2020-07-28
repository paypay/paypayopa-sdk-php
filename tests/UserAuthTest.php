<?php

require_once('TestBoilerplate.php');
use PayPay\OpenPaymentAPI\Models\UserAuthUrlInfo;

class UserAuthTest extends TestBoilerplate
{
    /**
     * Initialization test
     *
     * @return void
     */
    public function testInit()
    {
        $this->InitCheck();
    }
    /**
     * test for getUserAuthUrl
     *
     * @return void
     */
    public function testGetUrl()
    {
        $expiry = new DateTime();
        $expiry->add(new DateInterval('PT1H'));
        $payload = new UserAuthUrlInfo($this->config['mid'], $expiry, 'https://foobar.com/xyz', 'TESTUSER!@#');
        $url=$this->client->payment->getUserAuthUrl($payload);
        echo $url.'   ';
    }
    /**
     * test for decodeUserAuth
     *
     * @return void
     */
    public function testParseAuthResult()
    {
        var_dump($this->client->payment->decodeUserAuth($this->config['uaresponse']));
    }
}
