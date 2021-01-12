<?php

namespace PayPay\OpenPaymentAPI\Models;

use function PayPay\OpenPaymentAPI\Helpers\GetRand;

class AccountLinkPayload extends Model
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $scopes;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $nonce;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $redirectType;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $redirectUrl;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $referenceId;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $phoneNumber;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $deviceId;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $userAgent;

    public function __construct()
    {
        $this->_memberize("scopes", "array");
        $this->_memberize("nonce", "string", 255);
        $this->_memberize("redirectUrl", "string", 255);
        $this->_memberize("referenceId", "string", 255);
        $this->setNonce();
    }

    /**
     * Get the value of scopes
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Set the value of scopes
     * @param array $scopes
     * @return  self
     */
    public function setScopes($scopes)
    {
        $allowedScopes = [
            "direct_debit",
            "cashback",
            "get_balance",
            "quick_pay",
            "continuous_payments",
            "merchant_topup",
            "pending_payments",
            "user_notification",
            "user_topup",
            "user_profile",
            "preauth_capture_native",
            "preauth_capture_transaction",
            "push_notification",
            "notification_center_ob",
            "notification_center_ab",
            "notification_center_tl"
        ];
        $diff = array_diff($scopes, $allowedScopes);
        if (sizeof($diff)===0) {
            $this->scopes = $scopes;

            return $this;
        } else {
            throw new \Exception("Invalid Scope found.", 500);
        }
    }

    /**
     * Get the value of nonce
     * @return string
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * Set the value of nonce
     * @return  self
     */
    public function setNonce()
    {
        $this->nonce = GetRand(160);

        return $this;
    }

    /**
     * Get the value of redirectType
     * @return string
     */
    public function getRedirectType()
    {
        return $this->redirectType;
    }

    /**
     * Set the value of redirectType
     * @param string $redirectType "APP_DEEP_LINK" or "WEB_LINK"
     *
     * @return  self
     */
    public function setRedirectType($redirectType)
    {
        if (!in_array($redirectType, ["APP_DEEP_LINK", "WEB_LINK"])) {
            throw new \Exception("Invalid redirect type", 500);
        }


        $this->_memberize("redirectType", "string");
        $this->redirectType = $redirectType;

        return $this;
    }

    /**
     * Get the value of redirectUrl
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Set the value of redirectUrl
     * @param string $redirectUrl
     *
     * @return  self
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * Get the value of referenceId
     * @return string
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * Set the value of referenceId
     * @param string $referenceId
     * @return  self
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     * @param string $phoneNumber
     * @return  self
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->_memberize("phoneNumber", "string");
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Get the value of deviceId
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set the value of deviceId
     * @param string $deviceId
     * @return  self
     */
    public function setDeviceId($deviceId)
    {
        $this->_memberize("deviceId", "string", 255);
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get the value of userAgent
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set the value of userAgent
     * @param string $userAgent
     * @return  self
     */
    public function setUserAgent($userAgent)
    {
        $this->_memberize("userAgent", "string", 255);
        $this->userAgent = $userAgent;

        return $this;
    }
}
