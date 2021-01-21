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

class Payment extends Controller
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
     * Create a direct debit payment and start the money transfer.
     *
     * @param CreatePaymentPayload $payload SDK payload object
     * @param boolean $agreeSimilarTransaction (Optional) If the parameter is set to "true", the payment duplication check will be bypassed.
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     * @throws GuzzleException
     */
    public function createPayment($payload, $agreeSimilarTransaction = false)
    {
        $this->payloadTypeCheck($payload, new CreatePaymentPayload());
        $data = $payload->serialize();
        $header =  $this->headerConstant;
        $url = $this->api_url . $this->main()->GetEndpoint('PAYMENT');
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT');
        $options = $this->HmacCallOpts('POST', $endpoint, $header, $data);
        $options['TIMEOUT'] = 30;
        if ($agreeSimilarTransaction) {
            return $this->doSimilarTransactionCall("v2_createPayment", $url, $options, $data);
        } else {
            return $this->doCall(true, "v2_createPayment", $url, $data, $options);
        }
    }
    /**
     * Create a direct debit payment and start the money transfer.
     *
     * @param CreateContinuousPaymentPayload $payload SDK payload object
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     */
    public function createContinuousPayment($payload)
    {
        if (!($payload instanceof CreateContinuousPaymentPayload)) {
            throw new ModelException("Payload not of type CreateContinuousPaymentPayload", 500, []);
        }
        $data = $payload->serialize();
        $version = $this->main()->GetEndpointVersion('SUBSCRIPTION');
        $url = $this->api_url . $this->main()->GetEndpoint('SUBSCRIPTION');
        $url = str_replace('v2', $version, $url);
        $endpoint = '/' . $version . $this->main()->GetEndpoint('SUBSCRIPTION');
        $header = $this->headerConstant;
        $options = $this->HmacCallOpts('POST', $endpoint, $header, $data);
        $options['TIMEOUT'] = 30;
        return $this->doCall(true, "v1_createSubscriptionPayment", $url, $data, $options);
    }
    /**
     * Create a pending payment and initialize the money transfer.
     *
     * @param CreatePendingPaymentPayload $payload SDK payload object
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     */
    public function createPendingPayment($payload)
    {
        if (!($payload instanceof CreatePendingPaymentPayload)) {
            throw new ModelException("Payload not of type CreatePendingPaymentPayload", 500, []);
        }
        $data = $payload->serialize();
        $version = $this->main()->GetEndpointVersion('REQUEST_ORDER');
        $header = $this->headerConstant;
        $options = $this->HmacCallOpts('POST', ('/' . $version . $this->main()->GetEndpoint('REQUEST_ORDER')), $header, $data);
        $options['TIMEOUT'] = 30;
        /** @phpstan-ignore-next-line */
        return $this->doCall(true, "v1_createRequestOrder", str_replace('v2', $version, ($this->api_url . $this->main()->GetEndpoint('REQUEST_ORDER'))), $data, $options);
    }

    /**
     * Fetches Payment details
     *
     * @param string $merchantPaymentId The unique payment transaction id provided by merchant
     * @param string $paymentType Type of payment e.g. pending, continuous, direct_debit,web_cashier,dynamic_qr,app_invoke
     * @return array
     * @throws ClientControllerException
     */
    public function getPaymentDetails($merchantPaymentId, $paymentType = 'web_cashier')
    {
        $endpoint = $this->endpointByPaymentType($paymentType, $merchantPaymentId)['endpoint'];
        $url = $this->endpointByPaymentType($paymentType, $merchantPaymentId)['url'];
        $options = $this->HmacCallOpts('GET', $endpoint);
        return $this->doCall(true, "v2_getPaymentDetail", $url, [], $options);
    }

    /**
     * Cancel a payment:
     * This method is used in case, while creating a payment, the client can not determine the status of the payment.
     * For example, client get timeout or the response cannot contain the information to indicate the exact payment status.
     * By calling this api, if accepted, the OPA will guarantee the money eventually goes back to user's account.
     * Note: The Cancel API can be used until 00:14:59 AM the day after the Payment has happened.
     *       For 00:15 AM or later, please call the refund method to refund the payment.
     * @param string $merchantPaymentId The unique payment transaction id provided by merchant
     * @param string $paymentType Type of payment e.g. pending, continuous, direct_debit,web_cashier,dynamic_qr,app_invoke
     * @return array
     * @throws ClientControllerException
     */
    public function cancelPayment($merchantPaymentId, $paymentType = 'web_cashier')
    {
        $endpoint = $this->endpointByPaymentType($paymentType, $merchantPaymentId)['endpoint'];
        $url = $this->endpointByPaymentType($paymentType, $merchantPaymentId)['url'];
        $options = $this->HmacCallOpts('DELETE', $endpoint);
        return $this->doCall(true, "v2_cancelPayment", $url, [], $options);
    }

    /**
     * Create preauthorized payment request
     *
     * @param CreatePaymentAuthPayload $payload
     * @param boolean $agreeSimilarTransaction If set to true, payment duplication check will be bypassed
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     * @throws GuzzleException
     */
    public function createPaymentAuth($payload, $agreeSimilarTransaction = false)
    {
        $this->payloadTypeCheck($payload, new CreatePaymentAuthPayload());
        $data = $payload->serialize();
        $url = $this->api_url . $this->main()->GetEndpoint('PAYMENT_PREAUTH');
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT_PREAUTH');
        $header = $this->headerConstant;
        $options = $this->HmacCallOpts('POST', $endpoint, $header, $data);
        $options['TIMEOUT'] = 30;
        if ($agreeSimilarTransaction) {
            return $this->doSimilarTransactionCall("v2_createOrderAndAuthorize", $url, $options, $data);
        } else {
            return $this->doCall(true, "v2_createOrderAndAuthorize", $url, $data, $options);
        }
    }

    /**
     * For payments to be updated with amount after creation,
     * this method is used to capture the payment authorization
     * for a payment
     *
     * @param CapturePaymentAuthPayload $payload SDK payload object
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     */
    public function capturePaymentAuth($payload)
    {
        $this->payloadTypeCheck($payload, new CapturePaymentAuthPayload());
        $main = $this->MainInst;
        $data = $payload->serialize();
        $url = $main->GetConfig('API_URL') . $main->GetEndpoint('PAYMENT') . "/capture";
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT') . "/capture";
        $header = $this->headerConstant;
        $options = $this->HmacCallOpts('POST', $endpoint, $header, $data);
        $options['TIMEOUT'] = 30;
        return $this->doCall(true, "v2_captureAuthorizedOrder", $url, $data, $options);
    }

    /**
     * For payments to be updated with amount after creation,
     * This api is used in case the merchant wants to cancel
     * the payment authorization because of cancellation of
     * the order by the user.
     *
     * @param RevertAuthPayload $payload SDK payload object
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     */
    public function revertAuth($payload)
    {
        $this->payloadTypeCheck($payload, new RevertAuthPayload());
        $main = $this->MainInst;
        $data = $payload->serialize();
        $url = $main->GetConfig('API_URL') . $main->GetEndpoint('PAYMENT') . "/preauthorize/revert";
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT') . "/preauthorize/revert";
        $header = $this->headerConstant;
        $options = $this->HmacCallOpts('POST', $endpoint, $header, $data);
        $options['TIMEOUT'] = 30;
        return $this->doCall(true, "v2_revertAuthorizedOrder", $url, $data, $options);
    }
    /**
     * Generic HTTP call for similar transaction
     *
     * @param string $apiId
     * @param string $url
     * @param array $options
     * @param array $data
     * @return array
     * @throws ClientControllerException
     * @throws GuzzleException
     */
    private function doSimilarTransactionCall($apiId, $url, $options, $data)
    {
        $apiInfo = $this->main()->GetApiMapping($apiId);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }

        try {
            $response = $this->main()->http()->post(
                $url,
                [
                    'headers' => $options["HEADERS"],
                    'json' => $data,
                    'query' => ['agreeSimilarTransaction' => true],
                    'timeout' => $options['TIMEOUT']
                ]
            );
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
            }
        } finally {
            $responseData = json_decode($response->getBody(), true);
            $resultInfo = $responseData["resultInfo"];
            $this->parseResultInfo($apiInfo, $resultInfo, $response->getStatusCode());
            return $responseData;
        }
    }
    // Class helper
    /**
     * Returns endpoint data by payment type for payment details and cancellation
     *
     * @param String $paymentType Type of payment e.g. pending, continuous, direct_debit,web_cashier,dynamic_qr,app_invoke
     * @param String $merchantPaymentId The merchant payment id for transaction
     * @return array
     */
    private function endpointByPaymentType($paymentType, $merchantPaymentId)
    {
        $main = $this->main();
        switch ($paymentType) {
            case 'pending':
                $version = $this->main()->GetEndpointVersion('REQUEST_ORDER');
                $endpoint = "/${version}" . $main->GetEndpoint('REQUEST_ORDER') . "/$merchantPaymentId";
                $url = $this->api_url . $main->GetEndpoint('REQUEST_ORDER') . "/$merchantPaymentId";
                $url = str_replace('v2', $version, $url);
                break;

            default:
                $endpoint = '/v2' . $main->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
                $url = $this->api_url . $main->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
                break;
        }
        return ["endpoint" => $endpoint, "url" => $url];
    }
}