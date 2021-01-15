<?php

namespace PayPay\OpenPaymentAPI\Models;

use Exception;

class ModelException extends Exception
{
    /**
     * list of error fields
     *
     * @var array
     */
    public $fields;

    /**
     * Wrapper function for excedption constructor
     *
     * @param string $message Error message
     * @param integer $code Error code
     * @param array $fields List of error fields
     */
    public function __construct($message, $code, $fields)
    {
        $this->fields=$fields;
        parent::__construct($message, $code);
    }
}
