<?php
namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class CreatePaymentAuthPayload extends BasePaymentPayload
{
   
    /**
     * Expiry timestamp
     *
     * @var integer
     */
    protected $expiresAt;
    

    public function __construct()
    {
        $this->_memberize("merchantPaymentId", "string");
        $this->_memberize("userAuthorizationId", "string");
        $this->_memberize("amount", "array");
        $this->_memberize("requestedAt", "integer");
    }

   

    /**
     * Get the value of expiresAt
     * @return integer
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set the value of expiresAtTakes current server time automatically if no value is passed.
     * @param DateTime|boolean $expiresAt
     * @return  self
     */
    public function setExpiresAt($expiresAt)
    {
        $this->_memberize("expiresAt", "integer");
        /** @phpstan-ignore-next-line */
        $this->expiresAt = $expiresAt ? $expiresAt->getTimestamp() : time();

        return $this;
    }
}
