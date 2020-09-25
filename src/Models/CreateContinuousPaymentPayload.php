<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;
use Exception;

class CreateContinuousPaymentPayload extends BasePaymentPayload
{
    public function __construct()
    {
        $this->_memberize('merchantPaymentId', 'string',64);
        $this->_memberize('userAuthorizationId', 'string',64);
        $this->_memberize('amount', 'array');
        $this->_memberize('requestedAt', 'integer');
    }

}
