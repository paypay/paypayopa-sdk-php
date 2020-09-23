<?php
require_once('TestBoilerplate.php');

use PayPay\OpenPaymentAPI\Models\AccountLinkPayload;

class AccountLinkTest extends TestBoilerplate
{
    
    function testDecode(){
        $uaresponse  = $this->config['uaresponse'];
        $data = $this->client->user->decodeUserAuth($uaresponse);
        var_dump($data);
        $this->assertTrue(isset($data['userAuthorizationId']));
    }
}

