<?php

namespace PayPay\OpenPaymentAPI\Controller;

use Exception;
use PayPay\OpenPaymentAPI\Client;

class ClientControllerException extends Exception{}
class Controller
{
    /**
     * API URL
     *
     * @var string
     */
    protected $api_url;
    /**
     *  Main instance ()
     *
     * @var Client
     */
    protected $MainInst;
    /**
     * Auth info
     *
     * @var array
     */
    protected $auth;
    /**
     * default post options
     *
     * @var array
     */
    protected $basePostOptions;
    /**
     * Initializes Code class to manage creation and deletion of data for QR Code generation
     *
     * @param Client $MainInstance Instance of invoking client class
     * @param Array $auth API credentials
     */
    public function __construct($MainInstance, $auth)
    {
        $this->MainInst = $MainInstance;
        $this->api_url = $this->MainInst->getConfig('API_URL');
        $this->auth = $auth;
        $AuthStr = HttpBasicAuthStr($this->auth['API_KEY'], $this->auth['API_SECRET']);
        $this->basePostOptions = [
            'CURLOPT_TIMEOUT' => 15,
            'HEADERS' => [
                'Content-Type' => 'application/json',
                'Authorization' => $AuthStr
            ]
        ];
    }
    /**
     * Get Hmac headers
     *
     * @param string $HttpMethod
     * @param string $PaypayEndpoint
     * @param string $ContentType
     * @param array $RequestData
     * @return array  
     */
    protected function HmacCallOpts($HttpMethod, $PaypayEndpoint, $ContentType = 'empty', $RequestData = null)
    {
        $AuthStr = PayPayEncryptHeader(
            $this->auth['API_KEY'],
            $this->auth['API_SECRET'],
            $HttpMethod,
            $PaypayEndpoint,
            $ContentType,
            $RequestData
        );

        $PostOpts = [
            'CURLOPT_TIMEOUT' => 15,
            'HEADERS' => [
                'Content-Type' => $ContentType,
                'Authorization' => $AuthStr
            ]
        ];
        return $PostOpts;
    }
    /**
     * Main client accessor
     *
     * @return Client
     */
    protected function main()
    {
        return $this->MainInst;
    }
    protected function payloadTypeCheck($payload,$type){
        if (!(get_class($payload) === get_class($type))) {
            throw new ClientControllerException("Payload not of type ".gettype($type), 500);
        }
    }
}
