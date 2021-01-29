<?php

namespace PayPay\OpenPaymentAPI\Controller;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Models\CapturePaymentAuthPayload;
use PayPay\OpenPaymentAPI\Models\CreateContinuousPaymentPayload;
use PayPay\OpenPaymentAPI\Models\CreatePaymentAuthPayload;
use PayPay\OpenPaymentAPI\Models\CreatePaymentPayload;
use PayPay\OpenPaymentAPI\Models\CreatePendingPaymentPayload;
use PayPay\OpenPaymentAPI\Models\ModelException;
use PayPay\OpenPaymentAPI\Models\RevertAuthPayload;
use PayPay\OpenPaymentAPI\Models\CashBackPayload;

class CashBack extends Controller
{
    /**
     * HEADER
     *
     * @var string
     */
    public $headerConstant = 'application/json;charset=UTF-8;';
    
    /**
     * Initializes Code class to manage creation and deletion of data for QR Code generation
     *
     * @param Client $MainInstance Instance of invoking client class
     * @param array $auth API credentials
     */
    public function __construct($MainInstance, $auth)
    {
        parent::__construct($MainInstance, $auth);
    }

    /**
     * Give cashback
     *
     * @param CashBackPayload $payload SDK payload object
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     */
    public function giveCashback($payload)
    {
        // unset($payload->merchantCashbackReversalId);
        $payload->merchantCashbackReversalId = "dummy";
        $this->payloadTypeCheck($payload, new CashBackPayload());
        $data = $payload->serialize();
        $header =  $this->headerConstant;
        $url =  $this->api_url . $this->main()->GetEndpoint('CASHBACK');
        $endpoint = '/v2' . $this->main()->GetEndpoint('CASHBACK');
        $options = $this->HmacCallOpts('POST', $endpoint, $header, $data);
        $options['TIMEOUT'] = 30;
        var_dump('urll:', $url);
        return $this->doCall(true, "v2_createCashBackRequest", $url, $data, $options);
    }


    /**
     * Check cashback details
     *
     * @param string $merchantPaymentId The unique payment transaction id provided by merchant
     * @param string $paymentType Type of payment e.g. pending, continuous, direct_debit,web_cashier,dynamic_qr,app_invoke
     * @return array
     * @throws ClientControllerException
     */
    public function getCashbackDetails($merchatCashbackId, $paymentType = 'CASHBACK')
    {
        $main = $this->MainInst;
        $url = $main->GetConfig('API_URL') . $main->GetEndpoint('CASHBACK') . "/$merchatCashbackId";
        $endpoint = '/v2' . $main->GetEndpoint('CASHBACK') . "/$merchatCashbackId";
        $options = $this->HmacCallOpts('GET', $endpoint);

        return $this->doCall(true, "v2_getCashbackDetails", $url, [], $options);
    }


    /**
    * Reversal cashback
    *
    * @param CashBackPayload $payload SDK payload object
    * @return array
    * @throws ClientControllerException
    * @throws ModelException
    */
    public function reverseCashBack($payload)
    {
        var_dump('payload:: ');
        var_dump($payload);
        $this->payloadTypeCheck($payload, new CashBackPayload());
        $data = $payload->serialize();
        $header =  $this->headerConstant;
        $url = $this->api_url ."/cashback_reversal"; // $this->main()->GetEndpoint('CASHBACK');
        $endpoint = '/v2' . "/cashback_reversal"; // $this->main()->GetEndpoint('CASHBACK');
        $options = $this->HmacCallOpts('POST', $endpoint, $header, $data);
        $options['TIMEOUT'] = 30;
        return $this->doCall(true, "v2_createReverseCashBackRequest", $url, $data, $options);
    }

    /**
     * Check reversal cashback details
     *
     * @param string $merchantPaymentId The unique payment transaction id provided by merchant
     * @param string $paymentType Type of payment e.g. pending, continuous, direct_debit,web_cashier,dynamic_qr,app_invoke
     * @return array
     * @throws ClientControllerException
     */
    public function getReversalCashbackDetails($merchantCashbackReversalId, $merchatCashbackId)
    {
        $main = $this->MainInst;
        $url = $main->GetConfig('API_URL') . "/cashback_reversal" . "/$merchantCashbackReversalId" . "/$merchatCashbackId";
        $endpoint = '/v2' . "/cashback_reversal" . "/$merchantCashbackReversalId" . "/$merchatCashbackId";
        $options = $this->HmacCallOpts('GET', $endpoint);
        return $this->doCall(true, "v2_getReversedCashBackDetails", $url, [], $options);
    }
}