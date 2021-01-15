<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class CreateQrCodePayload extends BasePaymentInfo
{
  
    /**
     * Code Type
     *
     * @var string
     */
    protected $codeType;
    /**
     * Store Information
     *
     * @var string
     */
    protected $storeInfo;
    
    /**
     * Requested Timestamp
     *
     * @var string
     */
    protected $redirectUrl;
    /**
     * Redirect Type
     *
     * @var string
     */
    protected $redirectType;
    /**
     * User Agent
     *
     * @var string
     */
    protected $userAgent;
    /**
     * Authorization Flag
     *
     * @var boolean
     */
    protected $isAuthorization;
    /**
     * Authorization Timestamp
     *
     * @var integer
     */
    protected $authorizationExpiry;

    public function __construct()
    {
        $this->_memberize('merchantPaymentId', 'string', 64);
        $this->_memberize('amount', 'array');
        $this->_memberize('codeType', 'string');
    }

    /**
     * Get the value of codeType
     * @return string
     */
    public function getCodeType()
    {
        return $this->codeType;
    }

    /**
     * Set the value of codeType
     * @param string $codeType
     * @return  self
     */
    public function setCodeType($codeType = "ORDER_QR")
    {
        $this->codeType = $codeType;

        return $this;
    }

    /**
     * Get the value of storeInfo
     * @return string
     */
    public function getStoreInfo()
    {
        return $this->storeInfo;
    }

    /**
     * Set the value of storeInfo
     * @param string $storeInfo
     * @return  self
     */
    public function setStoreInfo($storeInfo)
    {
        $this->_memberize('storeInfo', 'string', 255);
        $this->storeInfo = $storeInfo;
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
     *  @param string $redirectUrl
     * @return  self
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->_memberize('redirectUrl', 'string');
        $this->redirectUrl = $redirectUrl;

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
     *  @param string $redirectType
     * @return  self
     * @throws ModelException
     */
    public function setRedirectType($redirectType)
    {
        if ($redirectType === "WEB_LINK" || $redirectType === "APP_DEEP_LINK") {
            $this->_memberize('redirectType', 'string');
            $this->redirectType = $redirectType;
            return $this;
        } else {
            throw new ModelException("Invalid redirection type", 500, ['redirectType']);
        }
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
        $this->_memberize('userAgent', 'string');
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get the value of isAuthorization
     * @return boolean
     */
    public function getIsAuthorization()
    {
        return $this->isAuthorization;
    }

    /**
     * Set the value of isAuthorization
     * @param boolean $isAuthorization
     * @return  self
     */
    public function setIsAuthorization($isAuthorization)
    {
        $this->_memberize('isAuthorization', 'boolean');
        $this->isAuthorization = $isAuthorization;

        return $this;
    }

    /**
     * Get the value of authorizationExpiry
     * @return integer
     */
    public function getAuthorizationExpiry()
    {
        return $this->authorizationExpiry;
    }

    /**
     * Set the value of authorizationExpiry
     * @param DateTime $authorizationExpiry
     * @return  self
     */
    public function setAuthorizationExpiry($authorizationExpiry)
    {
        $this->_memberize('authorizationExpiry', 'integer');
        $this->authorizationExpiry = $authorizationExpiry->getTimestamp();

        return $this;
    }
}
