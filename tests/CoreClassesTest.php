<?php

use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\ClientException;

require_once('TestBoilerplate.php');

class CoreClassesTest extends TestBoilerplate
{
    function testClientNoAuth()
    {
        try {
            $client = new Client();
        } catch (ClientException $e) {
            $this->assertStringContainsString('Invalid auth credentials', $e->getMessage());
        }
    }
    function testClientStaging()
    {
        $config = [
            /** @phpstan-ignore-next-line */
            'API_KEY' => "API_KEY_STRING",
            /** @phpstan-ignore-next-line */
            'API_SECRET' => "API_KEY_STRING",
            /** @phpstan-ignore-next-line */
            'MERCHANT_ID' => "MERCHANT_IDENTIFIER_STRING"
        ];
        $client = new Client($config);
        $collector["URL"] = $client->GetConfig("API_URL");
        $collector["ENDPOINT"] = $client->GetEndpoint('SUBSCRIPTION');
        $collector["ENDPOINT_VERSION"] = $client->GetEndpointVersion('SUBSCRIPTION');
        $collector["MERCHANT_ID"] = $client->GetMid();
        foreach ($collector as $key => $value) {
            $this->assertNotNull($value,"${key} invalid");
        }
    }
    function testClientProduction()
    {
        $config = [
            /** @phpstan-ignore-next-line */
            'API_KEY' => "API_KEY_STRING",
            /** @phpstan-ignore-next-line */
            'API_SECRET' => "API_KEY_STRING",
            /** @phpstan-ignore-next-line */
            'MERCHANT_ID' => "MERCHANT_IDENTIFIER_STRING"
        ];
        $client = new Client($config,true);
        $collector["URL"] = $client->GetConfig("API_URL");
        $collector["ENDPOINT"] = $client->GetEndpoint('SUBSCRIPTION');
        $collector["ENDPOINT_VERSION"] = $client->GetEndpointVersion('SUBSCRIPTION');
        $collector["MERCHANT_ID"] = $client->GetMid();
        foreach ($collector as $key => $value) {
            $this->assertNotNull($value,"${key} invalid");
        }
    }
    function testClientTestMode()
    {
        $config = [
            /** @phpstan-ignore-next-line */
            'API_KEY' => "API_KEY_STRING",
            /** @phpstan-ignore-next-line */
            'API_SECRET' => "API_KEY_STRING",
            /** @phpstan-ignore-next-line */
            'MERCHANT_ID' => "MERCHANT_IDENTIFIER_STRING"
        ];
        $client = new Client($config,"test");
        $collector["URL"] = $client->GetConfig("API_URL");
        $collector["ENDPOINT"] = $client->GetEndpoint('SUBSCRIPTION');
        $collector["ENDPOINT_VERSION"] = $client->GetEndpointVersion('SUBSCRIPTION');
        $collector["MERCHANT_ID"] = $client->GetMid();
        foreach ($collector as $key => $value) {
            $this->assertNotNull($value,"${key} invalid");
        }
    }
    function testClientNoMid()
    {
        $config = [
            /** @phpstan-ignore-next-line */
            'API_KEY' => "API_KEY_STRING",
            /** @phpstan-ignore-next-line */
            'API_SECRET' => "API_KEY_STRING",
        ];
        $client = new Client($config);
        $this->assertFalse($client->GetMid());
    }
}
