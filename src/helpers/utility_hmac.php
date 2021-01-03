<?php

namespace PayPay\OpenPaymentAPI\Helpers;

/**
 * Random string generator
 *
 * @param int $n Length of random string
 * @return string
 */

function GetRand($n)
{

    // random_bytes returns number of bytes
    // bin2hex converts them into hexadecimal format
    return substr(
        bin2hex(random_bytes($n)),
        0,
        $n
    );
}

/**
 * Returns Authorization header to use in HTTP calls
 *
 * @param string $apiKey API Key/Client ID
 * @param string $apiSecret API Secret/Secret ID
 * @param string $method HTTP method used. ["GET","POST","DELETE",etc.]
 * @param string $resource API endpoint being accessed
 * @param string $contentType Content Type of call. E.g. "application/json;charset=UTF-8;". Leave 'empty' on GET calls.
 * @param array|null $payload The data to be sent to the server.
 * @return string Value to be passed in authorization header
 */
function PayPayEncryptHeader($apiKey, $apiSecret, $method, $resource, $contentType, $payload)
{
    $CLIENT_KEY = $apiKey;
    $SECRET_KEY = $apiSecret;
    $httpMethod = $method;
    $AUTH_TYPE = 'hmac OPA-Auth';
    $requestUrl = $resource;


    $requestTimeStamp = time();
    $nonce = GetRand(16); //Fixed value for sample
    $bodyHash = $contentType === 'empty' ? $contentType : "";
    if ($contentType != 'empty') {
        // Read requestBody
        $requestBody = str_replace("\n", '', json_encode($payload));// @phpstan-ignore-line
        // MD5 hash of contentType and requestBody
        $bodyHash = base64_encode(md5("$contentType$requestBody", true));
    }
    $signatureRawData_list = array($requestUrl, $httpMethod, $nonce, $requestTimeStamp, $contentType, $bodyHash);
    $signatureRawData = implode("\n", $signatureRawData_list);


    // Create hmac-sha256
    $hash = hash_hmac('sha256', $signatureRawData, $SECRET_KEY, true);
    $hashInBase64 = base64_encode($hash);
    $header_list = array($CLIENT_KEY, $hashInBase64, $nonce, $requestTimeStamp, $bodyHash);
    $header = implode(":", $header_list);

    return $AUTH_TYPE . ":" . $header;
}
