<?php

use PayPay\OpenPaymentAPI\Controller\ClientControllerException;

require_once('TestBoilerplate.php');
final class ResolveTest extends BoilerplateTest
{
    public function testNonDocResolve()
    {
        $this->InitCheck();
        try {
            throw new ClientControllerException(false, "duck");
        } catch (ClientControllerException $e) {
            $this->assertStringContainsString("https://github.com/paypay/paypayopa-sdk-php/issues/new/choose", $e->getResolutionUrl(), 'Exception evaluates incorrectly');
        }
    }
    public function testDocumentedResolve()
    {
        try {
            $resultInfo =[
                
                "code"=>"UNAUTHORIZED",
                "message"=>"Unauthorized request",
                "codeId"=>"08100016"

            ];
            throw new ClientControllerException(
                $this->client->GetApiMapping("v2_createPayment"),
                $resultInfo, //PayPay API message
                500, // API response code
                $this->client->GetConfig('DOC_URL') // PayPay Resolve URL
            );
        } catch (ClientControllerException $e) {
            $this->assertStringContainsString($this->client->GetConfig('DOC_URL'), $e->getResolutionUrl(), 'Exception evaluates incorrectly');
        }
    }
}