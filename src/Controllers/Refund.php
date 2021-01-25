<?php

namespace PayPay\OpenPaymentAPI\Controller;

use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Models\ModelException;
use PayPay\OpenPaymentAPI\Models\RefundPaymentPayload;

class Refund extends Controller
{
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
     * Refund a payment
     *
     * @param RefundPaymentPayload $payload SDK payload object
     * @param String $paymentType Type of payment e.g. pending, continuous, direct_debit,web_cashier,dynamic_qr,app_invoke
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     */
    public function refundPayment($payload, $paymentType = 'web_cashier')
    {
        if (!($payload instanceof RefundPaymentPayload)) {
            throw new ClientControllerException(false, "Payload not of type RefundPaymentPayload", 1);
        }
        $main = $this->MainInst;
        $url = $main->GetConfig('API_URL') . $main->GetEndpoint('REFUND');
        $data = $payload->serialize();
        $code = "v2_createRefundPayment";
        $endpoint = '/v2' . $main->GetEndpoint('REFUND');
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        $options['TIMEOUT'] = 30;
        return $this->doCall(true, $code, $url, $data, $options);
    }

    /**
     * Get refund details.
     * @param String $merchantRefundId The unique refund transaction id provided by merchant
     * @return array
     * @throws ClientControllerException
     */
    public function getRefundDetails($merchantRefundId)
    {
        $main = $this->MainInst;
        $url = $main->GetConfig('API_URL') . $main->GetEndpoint('REFUND') . "/$merchantRefundId";
        $endpoint = '/v2' . $main->GetEndpoint('REFUND') . "/$merchantRefundId";
        $options = $this->HmacCallOpts('GET', $endpoint);

        return $this->doCall(true, "v2_getRefundDetails", $url, [], $options);
    }
}