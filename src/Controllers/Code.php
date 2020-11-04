<?php

namespace PayPay\OpenPaymentAPI\Controller;

use Exception;
use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;

class Code extends Controller
{
    /**
     * Initializes Code class to manage creation and deletion of data for QR Code generation
     *
     * @param Client $MainInstance Instance of invoking client class
     * @param Array $auth API credentials
     */
    public function __construct($MainInstance, $auth)
    {
        parent::__construct($MainInstance, $auth);
    }

    /**
     * Create a QR Code to receive payments.
     *
     * @param CreateQrCodePayload $payload SDK payload object
     * @return mixed
     */
    public function createQRCode($payload)
    {
        if (!($payload instanceof CreateQrCodePayload)) {
            throw new ClientControllerException(false,"Payload not of type CreateQrCodePayload", 1);
        }
        $url = $this->api_url . $this->main()->GetEndpoint('CODE');
        $data = $payload->serialize();
        $endpoint = '/v2' . $this->main()->GetEndpoint('CODE');
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        
        $options['TIMEOUT'] = 30;

        if ($data) {
            return $this->doCall(22,$url,$data,$options);
        }
    }
    /**
     * Fetches Payment details
     *
     * @param String $merchantPaymentId The unique payment transaction id provided by merchant
     * @return mixed
     */
    public function getPaymentDetails($merchantPaymentId)
    {
        $main = $this->MainInst;
        $endpoint = '/v2' . $this->main()->GetEndpoint('CODE') . $main->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
        $url = $this->api_url . $main->GetEndpoint('CODE') . $main->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
        $options = $this->HmacCallOpts('GET', $endpoint);
        
        return $this->doCall(23,$url,[],$options);
    }


    /**
     * Invalidates QR Code for payment
     *
     * @param String $codeId
     * @return mixed
     */
    public function deleteQRCode($codeId)
    {
        $endpoint = '/v2' . $this->main()->GetEndpoint('CODE') . "/$codeId";
        $options = $this->HmacCallOpts('DELETE', $endpoint);
        
        $url = $this->api_url . $this->main()->GetEndpoint('CODE') . "/$codeId";
        return $this->doCall(24,$url,[],$options);
    }
}
