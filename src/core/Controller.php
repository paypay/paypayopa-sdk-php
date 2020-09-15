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
        $this->basePostOptions = [
            'CURLOPT_TIMEOUT' => 15,
            'HEADERS' => [
                'Content-Type' => 'application/json',
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
    /**
     * Checks type of payload against empty payload object
     *
     * @param mixed $payload Request data payload object
     * @param mixed $type Empty payload object
     * @return void
     */
    protected function payloadTypeCheck($payload,$type){
        if (get_class($payload) !== get_class($type)) {
            throw new ClientControllerException("Payload not of type ".gettype($type), 500);
        }
    }
    /**
     * Generic HTTP calls
     *
     * @param string $callType HTTP method
     * @param string $url URL
     * @param array $data payload data array
     * @param array $options call options
     * @return array
     */
    protected function doCall($callType,$url,$data,$options){
        $request=$this->main()->http();
        $response = null;
        if ($callType == 'post') {
            $response = $request->$callType(
                $url,
                [
                    'headers' => $options["HEADERS"],
                    'json' => $data,
                    'timeout' => $options['TIMEOUT']
                ]
            );
        }
        if ($callType == 'get' || $callType == 'delete') {
            $response = $request->$callType(
                $url,
                [
                    'headers' => $options["HEADERS"]
                ]
            );
        }
        return json_decode($response->getBody(), true);

    }
}
