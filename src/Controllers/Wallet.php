<?php

namespace PayPay\OpenPaymentAPI\Controller;

use PayPay\OpenPaymentAPI\Client;

class Wallet extends Controller
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
     * Check if user has enough balance to make a payment
     *
     * @param string $userAuthorizationId
     * @param integer $amount
     * @param string $currency
     * @param string|boolean $productType
     * @return array
     * @throws ClientControllerException
     */
    public function checkWalletBalance($userAuthorizationId, $amount, $currency, $productType = false)
    {
        $data = [
            'userAuthorizationId' => $userAuthorizationId,
            'amount' => $amount,
            'currency' => $currency,
        ];
        if ($productType) {
            if ($productType === "VIRTUAL_BONUS_INVESTMENT" || $productType === "PAY_LATER_REPAYMENT") {
                $data['productType'] = $productType;
            } else {
                throw new ClientControllerException(false, "Invalid Direct Debit Product Type", 500);
            }
        }
        $url = $this->api_url . $this->main()->GetEndpoint('WALLET_BALANCE') . '?' . http_build_query($data);
        $endpoint = '/v2' . $this->main()->GetEndpoint('WALLET_BALANCE');
        $options = $this->HmacCallOpts('GET', $endpoint);

        return $this->doCall(true, "v2_checkWalletBalance", $url, [], $options);
    }
}
