<?php

namespace PayPay\OpenPaymentAPI\Models;

class OrderItem extends Model
{
    /**
     * Name of Product
     *
     * @var string
     */
    protected $name;
    /**
     * Product Category
     *
     * @var string
     */
    protected $category;
    /**
     * Quantity
     *
     * @var integer
     */
    protected $quantity;
    /**
     * Id of Product
     *
     * @var string
     */
    protected $productId;
    /**
     * Product pricing details
     *
     * @var array
     */
    protected $unitPrice;
    public function __construct()
    {
        $this->_memberize('name', 'string', 150);
        $this->_memberize('quantity', 'integer');
    }


    /**
     * Get the value of name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     * @param string $name
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of category
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     * @param string $category
     * @return  self
     */
    public function setCategory($category)
    {
        $this->_memberize('category', 'string', 255);
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of quantity
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     * @param integer $quantity
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of productId
     * @return string
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set the value of productId
     * @param string $productId
     * @return  self
     */
    public function setProductId($productId)
    {
        $this->_memberize('productId', 'string', 255);
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get the value of unitPrice
     * @return array
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set the value of unitPrice
     * @param array $unitPrice
     * @return  self
     * @throws ModelException
     */
    public function setUnitPrice($unitPrice)
    {
        $this->_memberize('unitPrice', 'array');
        if (!isset($unitPrice['currency']) || !isset($unitPrice['amount'])) {
            throw new ModelException("Invalid amount", 400, ['unitPrice']);
        }
        $this->unitPrice = $unitPrice;
        return $this;
    }
}
