<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class RefundPaymentPayload extends Model
{
    /**
     * Merchant Refund Id
     *
     * @var string
     */
    protected $merchantRefundId;
    /**
     * Payment Id
     *
     * @var string
     */
    protected $paymentId;
    /**
     *  Amount details
     *
     * @var array
     */
    protected $amount;
    /**
     * Request timestamp
     *
     * @var integer
     */
    protected $requestedAt;
    /**
     * reason for refund
     *
     * @var string
     */
    protected $reason;

    public function __construct()
    {
        $this->_memberize('merchantRefundId', 'string', 64);
        $this->_memberize('paymentId', 'string', 64);
        $this->_memberize('amount', 'array');
        $this->_memberize('requestedAt', 'integer');
    }

    /**
     * Get the value of merchantRefundId
     * @return string
     */
    public function getMerchantRefundId()
    {
        return $this->merchantRefundId;
    }

    /**
     * Set the value of merchantRefundId
     * @param string $merchantRefundId
     * @return  self
     */
    public function setMerchantRefundId($merchantRefundId)
    {
        $this->merchantRefundId = $merchantRefundId;

        return $this;
    }

    /**
     * Get the value of paymentId
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Set the value of paymentId
     * @param string $paymentId
     * @return  self
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;

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
