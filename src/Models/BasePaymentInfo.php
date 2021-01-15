<?php

namespace PayPay\OpenPaymentAPI\Models;

class BasePaymentInfo extends Model
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
     * Request timestamp
     *
     * @var integer
     */
    protected $requestedAt;
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
     * Set the value of orderItems
     * @param array $orderItems
     * @return  self
     * @throws ModelException
     */
    public function setOrderItems($orderItems)
    {
        $this->_memberize('orderItems', 'array');
        $serialized = [];
        foreach ($orderItems as $item) {
            if (get_class($item) !== 'PayPay\OpenPaymentAPI\Models\OrderItem') {
                throw new ModelException("Invalid Order Items", 403, ['orderItems']);
            }
            $serialized[] = $item->serialize();
        }

        $this->orderItems = $serialized;

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
        $this->_memberize('terminalId', 'string', 255);
        $this->terminalId = $terminalId;

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
        $this->_memberize('storeId', 'string', 255);
        $this->storeId = $storeId;

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
     * @param \DateTime|boolean $requestedAt
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
            throw new ModelException("Invalid amount", 403, ['amount']);
        }

        $this->amount = $amount;

        return $this;
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
     * Get order Items
     *
     * @return  array
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }
}
