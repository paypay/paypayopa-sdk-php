<?php

namespace PayPay\OpenPaymentAPI\Controller;

use \Firebase\JWT\JWT;
use PayPay\OpenPaymentAPI\Models\CapturePaymentAuthPayload;
use PayPay\OpenPaymentAPI\Models\CreatePaymentPayload;
use PayPay\OpenPaymentAPI\Models\RevertAuthPayload;
use PayPay\OpenPaymentAPI\Models\UserAuthUrlInfo;
use Exception;
use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Models\CreatePaymentAuthPayload;

class Payment extends Controller
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
     * Create a direct debit payment and start the money transfer.
     *
     * @param CreatePaymentPayload $payload SDK payload object
     * @param boolean $agreeSimilarTransaction (Optional) If the parameter is set to "true", the payment duplication check will be bypassed.
     * @return mixed
     */
    public function createPayment($payload, $agreeSimilarTransaction = false)
    {
        if (!($payload instanceof CreatePaymentPayload)) {
            throw new Exception("Payload not of type CreateQrCodePayload", 1);
        }
        $data = $payload->serialize();

        $url = $this->api_url . $this->main()->GetEndpoint('PAYMENT');
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT');
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $options['CURLOPT_TIMEOUT'] = 30;
        if ($agreeSimilarTransaction) {
            $response = HttpRequest('POST', $url, ['agreeSimilarTransaction' => true], $data, $options);
            /** @phpstan-ignore-next-line */
            return json_decode($response, true);
        } else {
            /** @phpstan-ignore-next-line */
            return json_decode(HttpPost($url, $data, $options), true);
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
        $endpoint = '/v2' . $main->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
        $url = $this->api_url . $main->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
        $options = $this->HmacCallOpts('GET', $endpoint);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        /** @phpstan-ignore-next-line */
        return json_decode(HttpGet($url, [], $options), true);
    }

    /**
     * Cancel a payment:
     * This method is used in case, while creating a payment, the client can not determine the status of the payment.
     * For example, client get timeout or the response cannot contain the information to indicate the exact payment status.
     * By calling this api, if accepted, the OPA will guarantee the money eventually goes back to user's account.
     * Note: The Cancel API can be used until 00:14:59 AM the day after the Payment has happened.
     *       For 00:15 AM or later, please call the refund method to refund the payment.
     * @param String $merchantPaymentId The unique payment transaction id provided by merchant
     * @return mixed
     */
    public function cancelPayment($merchantPaymentId)
    {
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
        $url = $this->api_url . $this->main()->GetEndpoint('PAYMENT') . "/$merchantPaymentId";
        $options = $this->HmacCallOpts('DELETE', $endpoint);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }

        /** @phpstan-ignore-next-line */
        return json_decode(HttpDelete($url, [], $options), true);
    }

    /**
     * Create preauthorized payment request
     *
     * @param CreatePaymentAuthPayload $payload
     * @param boolean $agreeSimilarTransaction If set to true, payment duplication check will be bypassed
     * @return mixed
     */
    public function createPaymentAuth($payload, $agreeSimilarTransaction=false)
    {
        if (!($payload instanceof CreatePaymentAuthPayload)) {
            throw new Exception("Payload not of type CreatePaymentAuthPayload", 1);
        }
        $data = $payload->serialize();

        $url = $this->api_url . $this->main()->GetEndpoint('PAYMENT_PREAUTH');
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT_PREAUTH');
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $options['CURLOPT_TIMEOUT'] = 30;
        if ($agreeSimilarTransaction) {
            $response = HttpRequest('POST', $url, ['agreeSimilarTransaction' => true], $data, $options);
            /** @phpstan-ignore-next-line */
            return json_decode($response, true);
        } else {
            /** @phpstan-ignore-next-line */
            return json_decode(HttpPost($url, $data, $options), true);
        }
    }

    /**
     * For payments to be updated with amount after creation,
     * this method is used to capture the payment authorization
     * for a payment
     *
     * @param CapturePaymentAuthPayload $payload SDK payload object
     * @return mixed
     */
    public function capturePaymentAuth($payload)
    {
        if (!($payload instanceof CapturePaymentAuthPayload)) {
            throw new Exception("Payload not of type CapturePaymentAuthPayload", 1);
        }
        $main = $this->MainInst;
        $data = $payload->serialize();
        $url = $main->GetConfig('API_URL') . $main->GetEndpoint('PAYMENT') . "/capture";
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT') . "/capture";
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $options['CURLOPT_TIMEOUT'] = 30;
        /** @phpstan-ignore-next-line */
        return json_decode(HttpPost($url, $data, $options), true);
    }

    /**
     * For payments to be updated with amount after creation,
     * This api is used in case the merchant wants to cancel
     * the payment authorization because of cancellation of
     * the order by the user.
     *
     * @param RevertAuthPayload $payload SDK payload object
     * @return mixed
     */
    public function revertAuth($payload)
    {
        if (!($payload instanceof RevertAuthPayload)) {
            throw new Exception("Payload not of type RevertAuthPayload", 1);
        }
        $main = $this->MainInst;
        $data = $payload->serialize();
        $url = $main->GetConfig('API_URL') . $main->GetEndpoint('PAYMENT') . "/preauthorize/revert";
        $endpoint = '/v2' . $this->main()->GetEndpoint('PAYMENT') . "/preauthorize/revert";
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $options['CURLOPT_TIMEOUT'] = 30;
        /** @phpstan-ignore-next-line */
        return json_decode(HttpPost($url, $data, $options), true);
    }
}
