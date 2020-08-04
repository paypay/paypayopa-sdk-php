<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;
use Exception;

class CreateQrCodePayload extends Model
{
    /**
     * Merchant Payment ID
     *
     * @var string
     */
    protected $merchantPaymentId;
    /**
     *  Amount details
     *
     * @var array
     */
    protected $amount = [];
    /**
     * Order Description
     *
     * @var string
     */
    protected $orderDescription;
    /**
     *  Order Items
     *
     * @var array
     */
    protected $orderItems = [];
    /**
     * metadata
     *
     * @var array
     */
    protected $metadata = [];
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
     * Store Id
     *
     * @var string
     */
    protected $storeId;
    /**
     * Terminal ID
     *
     * @var string
     */
    protected $terminalId;
    /**
     * Request timestamp
     *
     * @var integer
     */
    protected $requestedAt;
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
        $this->_memberize('merchantPaymentId', 'string',64);
        $this->_memberize('amount', 'array');
        $this->_memberize('codeType', 'string');
    }



    /**
     * Get the value of merchantPaymentId
     * @return string
     */
    public function getMerchantPaymentId()
    {
        return $this->merchantPaymentId;
    }

    /**
     * Set the value of merchantPaymentId
     *
     * @param string $merchantPaymentId
     * @return self
     */
    public function setMerchantPaymentId($merchantPaymentId)
    {
        $this->merchantPaymentId = $merchantPaymentId;

        return $this;
    }

    /**
     * Get the value of amount
     * @return array
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     * @param array $amount
     * @return  self
     */
    public function setAmount($amount)
    {
        if (!isset($amount['currency']) || !isset($amount['amount'])) {
            throw new Exception("Invalid amount");
        }

        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of orderDescription
     * @return string
     */
    public function getOrderDescription()
    {
        return $this->orderDescription;
    }

    /**
     * Set the value of orderDescription
     * @param string $orderDescription
     * @return  self
     */
    public function setOrderDescription($orderDescription)
    {
        $this->_memberize('orderDescription', 'string',255);
        $this->orderDescription = $orderDescription;
        return $this;
    }

    /**
     * Get the value of orderItems
     * @return array
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * Set the value of orderItems
     * @param array $orderItems
     * @return  self
     */
    public function setOrderItems($orderItems)
    {
        $this->_memberize('orderItems', 'array');
        $serialized = [];
        foreach ($orderItems as $item) {
            if (get_class($item) !== 'PayPay\OpenPaymentAPI\Models\OrderItem') {
                throw new Exception("Invalid Order Items");
            }
            $serialized[] = $item->serialize();
        }

        $this->orderItems = $serialized;

        return $this;
    }

    /**
     * Get the value of metadata
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set the value of metadata
     * @param array $metadata
     * @return  self
     */
    public function setMetadata($metadata)
    {
        $this->_memberize('metadata', 'array');
        $this->metadata = $metadata;

        return $this;
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
        $this->_memberize('storeInfo', 'string',255);
        $this->storeInfo = $storeInfo;
        return $this;
    }

    /**
     * Get the value of storeId
     * @return string
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Set the value of storeId
     * @param string $storeId
     * @return  self
     */
    public function setStoreId($storeId)
    {
        $this->_memberize('storeId', 'string',255);
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * Get the value of terminalId
     * @return string
     */
    public function getTerminalId()
    {
        return $this->terminalId;
    }

    /**
     * Set the value of terminalId
     * @param string $terminalId
     * @return  self
     */
    public function setTerminalId($terminalId)
    {
        $this->_memberize('terminalId', 'string',255);
        $this->terminalId = $terminalId;

        return $this;
    }

    /**
     * Get the value of requestedAt
     * @return integer
     */
    public function getRequestedAt()
    {
        return $this->requestedAt;
    }

    /**
     * Set the value of requestedAt. Takes current server time automatically if no value is passed.
     * @param DateTime|boolean $requestedAt
     * @return  self
     */
    public function setRequestedAt($requestedAt = false)
    {
        $this->_memberize('requestedAt', 'integer');
        /** @phpstan-ignore-next-line */
        $this->requestedAt = $requestedAt ? $requestedAt->getTimestamp() : time();
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
     */
    public function setRedirectType($redirectType)
    {
        if ($redirectType === "WEB_LINK" || $redirectType === "APP_DEEP_LINK") {
            $this->_memberize('redirectType', 'string');
            $this->redirectType = $redirectType;
            return $this;
        }else {
            throw new Exception("Invalid redirection type", 500);
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
