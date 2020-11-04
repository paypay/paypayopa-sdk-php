<?php
require_once('TestBoilerplate.php');

use PayPay\OpenPaymentAPI\Models\AccountLinkPayload;

class DecodeAccountLinkResponse extends TestBoilerplate
{
    
    function testDecode(){
        $uaresponse  = $this->config['uaresponse'];
        try {
            $data = $this->client->user->decodeUserAuth($uaresponse);
            var_dump($data);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $this->assertStringContainsString("Expired token",$message,"Some other error");
        }
    }
}

