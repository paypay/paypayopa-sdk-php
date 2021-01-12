<?php

namespace PayPay\OpenPaymentAPI\Models;

class CreatePaymentPayload extends BasePaymentPayload
{

    /**
     * Product Type
     *
     * @var string
     */
    protected $productType;
    public function __construct()
    {
        $this->_memberize('merchantPaymentId', 'string', 64);
        $this->_memberize('userAuthorizationId', 'string', 0);
        $this->_memberize('amount', 'array');
        $this->_memberize('requestedAt', 'integer');
    }

    /**
     * Get the value of productType
     *
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * Set the value of productType
     * @param string $productType
     * @return  self
     * @throws ModelException
     */
    public function setProductType($productType)
    {
        if ($productType === "VIRTUAL_BONUS_INVESTMENT" || $productType === "PAY_LATER_REPAYMENT") {
            $this->_memberize('productType', 'string', 24);
            $this->productType = $productType;

            return $this;
        }
        throw new ModelException("Invalid Direct Debit Product Type", 400, ['productType']);
    }
}
