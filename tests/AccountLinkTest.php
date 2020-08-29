<?php
require_once('TestBoilerplate.php');

use PayPay\OpenPaymentAPI\Models\AccountLinkPayload;

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
            ->setScopes(["direct_debit","preauth_capture_native"])
            ->setRedirectUrl("https://merchant.domain/test/callback")
            ->setReferenceId(uniqid("TEST123"));
        $resp = $client->user->createAccountLinkQrCode($payload);
        print_r('AuthURL:');
        var_dump($resp);
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
    function testDecode(){
        $uaresponse  = $this->config['uaresponse'];
        $data = $this->client->user->decodeUserAuth($uaresponse);
        var_dump($data);
        $this->assertTrue(isset($data['userAuthorizationId']));
    }
}

