<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class CreatePendingPaymentPayload extends BasePaymentPayload
{
    protected $expiryDate;
    public function __construct()
    {
        $this->_memberize('merchantPaymentId', 'string', 64);
        $this->_memberize('userAuthorizationId', 'string', 64);
        $this->_memberize('amount', 'array');
        $this->_memberize('requestedAt', 'integer');
    }

    /**
     * Get the value of expiryDate
     * @return integer
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set the value of expiryDate. If function is called with no arguments, expiry is 10 mins from current time. Validated whether value is set with minimum of 10 min and maximun 48 hours from current time. If not passed, expiry set as 6 hours by default.
     * @param DateTime|boolean $requestedAt
     * @return  self
     */
    public function setExpiryDate($requestedAt = false)
    {
        $this->_memberize('requestedAt', 'integer');
        /** @phpstan-ignore-next-line */
        $this->requestedAt = $requestedAt ? $requestedAt->getTimestamp() : (time() + 600000);
        return $this;
    }
}
