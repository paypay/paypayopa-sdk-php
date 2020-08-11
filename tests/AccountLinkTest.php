<?php
require_once('TestBoilerplate.php');

use PayPay\OpenPaymentAPI\Models\AccountLinkPayload;
use PayPay\OpenPaymentAPI\Models\Model;

class AccountLinkTest extends TestBoilerplate
{
    /**
     * Create Account Link
     *
     * @return void
     */
    public function Create()
    {
        $client = $this->client;
        $payload = new AccountLinkPayload();
        $payload
            ->setScopes(["continuous_payments","merchant_topup"])
            ->setRedirectUrl("http://localhost/reflector")
            ->setReferenceId(uniqid("TEST123"));
        print_r(json_encode($payload->serialize()));    
        $resp = $client->user->createAccountLinkQrCode($payload);
        $this->data = $resp;
    }    
    /**
     * 
     *
     * @return void
     */
    function testCreate()
    {
        $this->Create();
        $data = $this->data;
        // var_dump($data);
        $this->assertTrue(isset($data));
        $this->assertEquals('SUCCESS',$data['resultInfo']['code'],$data['resultInfo']['message'].':'.$data['transit'][4]);
    }
}

