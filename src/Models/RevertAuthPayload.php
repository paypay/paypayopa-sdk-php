<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class RevertAuthPayload extends Model
{
    /**
     * Undocmerchant Revert Id
     *
     * @var string
     */
    protected $merchantRevertId;
    /**
     * Payment Id
     *
     * @var string
     */
    protected $paymentId;
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

    public function __construct()
    {
        $this->_memberize("merchantRevertId", 'string', 64);
        $this->_memberize("paymentId", 'string', 64);
        $this->_memberize("requestedAt", 'integer');
    }

    /**
     * Get the value of merchantRevertId
     *
     * @return string
     */
    public function getMerchantRevertId()
    {
        return $this->merchantRevertId;
    }

    /**
     * Set the value of merchantRevertId
     * @param string $merchantRevertId
     * @return  self
     */
    public function setMerchantRevertId($merchantRevertId)
    {
        $this->merchantRevertId = $merchantRevertId;

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
        $this->_memberize("reason", 'string', 255);
        $this->reason = $reason;

        return $this;
    }
}
