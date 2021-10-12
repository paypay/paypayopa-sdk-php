<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class CashBackPayload extends Model // BasePaymentInfo
{
    /**
     * merchantCashbackId
     * @var string
     */
    protected $merchantCashbackId;

    /**
     * merchantCashbackReversalId
     * @var string
     */
    public $merchantCashbackReversalId;

    /**
     *  User Authorization ID
     *
     * @var string
     */
    protected $userAuthorizationId;

    /**
     *  Amount details
     *
     * @var array
     */
    protected $amount = [];

    /**
     * Request timestamp
     *
     * @var integer
     */
    protected $requestedAt;

    /**
     * Order Description
     *
     * @var string
     */
    protected $orderDescription;

    /**
     * walletType
     *
     * @var string
     */
    protected $walletType;

    /**
     * Request timestamp
     *
     * @var integer
     */
    protected $expiryDate;

    /**
     *  metadata details
     *
     * @var array
     */
    protected $metadata = [];

    public function __construct()
    {
        $this->_memberize('merchantCashbackId', 'string', 64);
        $this->_memberize('merchantCashbackReversalId', 'string', 64);
        $this->_memberize('userAuthorizationId', 'string', 0);
        $this->_memberize('amount', 'array');
        $this->_memberize('requestedAt', 'integer');
    }

    /**
     * Get the value of merchantCashbackId
     * @return string
     */
    public function getMerchantCashbackId()
    {
        return $this->merchantCashbackId;
    }

    /**
    * Set the value of merchantCashbackId
    * @param string $merchantCashbackId
    * @return  self
    */
    public function setMerchantCashbackId($merchantCashbackId)
    {
        $this->merchantCashbackId = $merchantCashbackId;

        return $this;
    }

    /**
     * Get the value of merchantCashbackReversalId
     * @return string
     */
    public function getMerchantCashbackReversalId()
    {
        return $this->merchantCashbackReversalId;
    }

    /**
    * Set the value of merchantCashbackReversalId
    * @param string $merchantCashbackReversalId
    * @return  self
    */
    public function setMerchantCashbackReversalId($merchantCashbackReversalId)
    {
        $this->merchantCashbackReversalId = $merchantCashbackReversalId;

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
            throw new ModelException("Invalid amount", 400, ['amount']);
        }

        $this->amount = $amount;

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
     * @param DateTime|false $requestedAt
     * @return  self
     */
    public function setRequestedAt($requestedAt = false)
    {
        $this->_memberize('requestedAt', 'integer');
        $this->requestedAt = $requestedAt ? $requestedAt->getTimestamp() : time();
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
        $this->_memberize('orderDescription', 'string', 255);
        $this->orderDescription = $orderDescription;

        return $this;
    }

    /**
     * Get the value of userAuthorizationId
     * @return string
     */
    public function getUserAuthorizationId()
    {
        return $this->userAuthorizationId;
    }

    /**
     * Set the value of userAuthorizationId
     * @param string $userAuthorizationId
     * @return  self
     */
    public function setUserAuthorizationId($userAuthorizationId)
    {
        $this->userAuthorizationId = $userAuthorizationId;

        return $this;
    }

    /**
     * Get the value of walletType
     * @return string
     */
    public function getWalletType()
    {
        return $this->walletType;
    }

    /**
     * Set the value of walletType
     * @param string $walletType
     * @return  self
     */
    public function setWalletType($walletType)
    {
        $this->_memberize('walletType', 'string');
        $this->walletType = $walletType;

        return $this;
    }
}