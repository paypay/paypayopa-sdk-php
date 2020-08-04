<?php

include('../src/Client.php');
use PayPay\OpenPaymentAPI\Client;

$client = new Client([
    'API_KEY' => 'YOUR_API_KEY',
    'API_SECRET'=>'YOUR_API_SECRET',
    'MERCHANT_ID'=>'YOUR_MERCHANT_ID'
]);
