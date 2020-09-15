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
            throw new Exception("Payload not of type CreateQrCodePayload", 1);
        }
        $url = $this->api_url . $this->main()->GetEndpoint('CODE');
        $data = $payload->serialize();
        $endpoint = '/v2' . $this->main()->GetEndpoint('CODE');
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $options['TIMEOUT'] = 30;

        if ($data) {
            $response = $this->main()->http()->post(
                $url,
                [
                    'headers' => $options["HEADERS"],
                    'json' => $data,
                    'timeout' => $options['TIMEOUT']
                ]
            );

            return json_decode($response->getBody(), true);
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
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $response = $this->main()->http()->get(
            $url,
            [
                'headers' => $options["HEADERS"]
            ]
        );
        return json_decode($response->getBody(), true);
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
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $url = $this->api_url . $this->main()->GetEndpoint('CODE') . "/$codeId";
        $response = $this->main()->http()->delete(
            $url,
            [
                'headers' => $options["HEADERS"]
            ]
        );
        return json_decode($response->getBody(), true);
    }
}
