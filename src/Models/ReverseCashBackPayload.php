<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class ReverseCashBackPayload extends Model
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
     * Reason
     *
     * @var string
     */
    protected $reason;

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
     * Get the value of reason
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set the value of reason
     * @param string $reason
     * @return  self
     */
    public function setReason($reason)
    {
        $this->_memberize('reason', 'string', 255);
        $this->reason = $reason;

        return $this;
    }


}