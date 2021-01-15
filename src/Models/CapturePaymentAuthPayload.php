<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class CapturePaymentAuthPayload extends Model
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
    protected $amount;
    /**
     * Merchant Capture ID
     *
     * @var string
     */
    protected $merchantCaptureId;
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

    public function __construct()
    {
        $this->_memberize("merchantPaymentId", 'string', 64);
        $this->_memberize("amount", 'array');
        $this->_memberize("merchantCaptureId", 'string', 64);
        $this->_memberize("requestedAt", 'integer');
        $this->_memberize("orderDescription", 'string', 255);
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
     * @throws ModelException
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
     * Get the value of merchantCaptureId
     * @return string
     */
    public function getMerchantCaptureId()
    {
        return $this->merchantCaptureId;
    }

    /**
     * Set the value of merchantCaptureId
     * @param string $merchantCaptureId
     * @return  self
     */
    public function setMerchantCaptureId($merchantCaptureId)
    {
        $this->merchantCaptureId = $merchantCaptureId;

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
        $this->orderDescription = $orderDescription;

        return $this;
    }
}
