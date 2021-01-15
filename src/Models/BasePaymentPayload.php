<?php

namespace PayPay\OpenPaymentAPI\Models;

class BasePaymentPayload extends BasePaymentInfo
{
    /**
     *  User Authorization ID
     *
     * @var string
     */
    protected $userAuthorizationId;

    /**
     * Order Receipt Number
     *
     * @var string
     */
    protected $orderReceiptNumber;

    /**
     * Get the value of orderReceiptNumber
     * @return string
     */
    public function getOrderReceiptNumber()
    {
        return $this->orderReceiptNumber;
    }

    /**
     * Set the value of orderReceiptNumber
     * @param string $orderReceiptNumber
     * @return  self
     */
    public function setOrderReceiptNumber($orderReceiptNumber)
    {
        $this->_memberize('orderReceiptNumber', 'string', 255);
        $this->orderReceiptNumber = $orderReceiptNumber;

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
}
