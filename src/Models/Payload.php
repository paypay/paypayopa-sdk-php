<?php

namespace PayPay\OpenPaymentAPI\Models;

use Exception;

class Payload
{
    private $merchantPaymentId;
    private $merchantCaptureId;
    private $merchantRevertId;
    private $merchantRefundId;
    private $requestedAt;
    private $amount;
    private $codeType;
    private $orderItems = [];
    private $redirectType;
    private $redirectUrl;
    private $orderDescription;
    private $storeInfo;
    private $storeId;
    private $terminalId;
    private $isAuthorization=false;
    private $authorizationExpiry;
    private $reason;
    private $userAuthorizationId;
    private $paymentId;



    public function set_merchant_payment_id($merchant_payment_id)
    {
        $this->merchantPaymentId = $merchant_payment_id;
    }

    public function get_merchant_payment_id()
    {
        $this->ValidateOne('merchantPaymentId');
        return $this->merchantPaymentId;
    }

    public function set_merchant_capture_id($merchant_capture_id)
    {
        $this->merchantCaptureId = $merchant_capture_id;
    }

    public function get_merchant_capture_id()
    {
        $this->ValidateOne('merchantCaptureId');
        return $this->merchantCaptureId;
    }


    public function set_merchant_revert_id($merchant_revert_id)
    {
        $this->merchantRevertId = $merchant_revert_id;
    }

    public function get_merchant_revert_id()
    {
        $this->ValidateOne('merchantRevertId');
        return $this->merchantRevertId;
    }

    public function set_merchant_refund_id($merchant_refund_id)
    {
        $this->merchantRefundId = $merchant_refund_id;
    }

    public function get_merchant_refund_id()
    {
        $this->ValidateOne('merchantRefundId');
        return $this->merchantRefundId;
    }

    public function set_amount($amount)
    {
        $this->amount = $amount;
    }

    public function get_amount()
    {
        $this->ValidateOne('amount');
        return $this->amount;
    }
    public function set_requested_at($requested_at = false)
    {
        $this->requestedAt = $requested_at ? $requested_at : time();
    }
    public function get_requested_at()
    {
        $this->ValidateOne('requestedAt');
        return $this->requestedAt;
    }
    public function set_code_type($code_type)
    {
        $this->codeType = $code_type;
    }
    public function get_code_type()
    {
        $this->ValidateOne('codeType');
        return $this->codeType;
    }
    public function set_order_items($order_items = [])
    {
        $this->orderItems = $order_items;
    }
    public function get_order_items()
    {
        $this->ValidateOne('orderItems');
        return $this->orderItems;
    }
    public function set_order_description($order_description)
    {
        $this->orderDescription = $order_description;
    }
    public function get_order_description()
    {
        $this->ValidateOne('orderDescription');
        return $this->orderDescription;
    }
    public function set_store_id($store_id)
    {
        $this->storeId = $store_id;
    }
    public function get_store_id()
    {
        $this->ValidateOne('storeId');
        return $this->storeId;
    }
    public function set_redirect_type($redirect_type)
    {
        $this->redirectType = $redirect_type;
    }
    public function get_redirect_type()
    {
        $this->ValidateOne('redirectType');
        return $this->redirectType;
    }
    public function set_redirect_url($redirect_url)
    {
        $this->redirectUrl = $redirect_url;
    }
    public function get_redirect_url()
    {
        $this->ValidateOne('redirectUrl');
        return $this->redirectUrl;
    }
    public function set_reason($reason)
    {
        $this->reason = $reason;
    }
    public function get_reason()
    {
        $this->ValidateOne('reason');
        return $this->reason;
    }

    public function set_authorization($isAuth)
    {
        $this->isAuthorization = $isAuth;
    }
    public function get_authorization()
    {
        $this->ValidateOne('isAuthorization');
        return $this->isAuthorization;
    }

    private function ValidateOne($entryName)
    {
        if (!isset($this->$entryName)) {
            throw new Exception("Payload value $entryName not set.");
        }
    }

    /**
     * Get the value of userAuthorizationId
     */
    public function get_user_authorization_id()
    {
        return $this->userAuthorizationId;
    }

    /**
     * Set the value of userAuthorizationId
     *
     * @return  self
     */
    public function set_user_authorization_id($userAuthorizationId)
    {
        $this->userAuthorizationId = $userAuthorizationId;
    }

    /**
     * Get the value of authorizationExpiry
     */
    public function getAuthorizationExpiry()
    {
        return $this->authorizationExpiry;
    }

    /**
     * Set the value of authorizationExpiry
     *
     * @return  self
     */
    public function setAuthorizationExpiry($authorizationExpiry)
    {
        $this->authorizationExpiry = $authorizationExpiry;

        return $this;
    }

    /**
     * Get the value of terminalId
     */
    public function getTerminalId()
    {
        return $this->terminalId;
    }

    /**
     * Set the value of terminalId
     *
     * @return  self
     */
    public function setTerminalId($terminalId)
    {
        $this->terminalId = $terminalId;

        return $this;
    }

    /**
     * Get the value of storeInfo
     */
    public function getStoreInfo()
    {
        return $this->storeInfo;
    }

    /**
     * Set the value of storeInfo
     *
     * @return  self
     */
    public function setStoreInfo($storeInfo)
    {
        $this->storeInfo = $storeInfo;

        return $this;
    }

    /**
     * Get the value of paymentId
     */
    public function get_payment_id()
    {
        return $this->paymentId;
    }

    /**
     * Set the value of paymentId
     *
     * @return  self
     */
    public function set_payment_id($paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }
}
