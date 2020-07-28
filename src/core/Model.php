<?php

namespace PayPay\OpenPaymentAPI\Models;

use Exception;

class Model
{
    /**
     * @var array
     */
    private $descriptor = [];
    /**
     * lock for validation
     *
     * @param string $name
     * @param string $type
     * @param boolean $required
     * @return void
     */
    protected function _memberize($name, $type, $required = false)
    {
        $this->descriptor[$name] = ['type' => $type, 'required' => $required];
    }
    /**
     * Enforce validations in descriptor
     *
     * @param boolean $throwErrors
     * @return boolean
     */
    public function validate($throwErrors = true)
    {
        $faults = [];
        $iterable = get_object_vars($this);
        foreach ($this->descriptor as $memberName => $memberInfo) {
            $member = $iterable[$memberName];
            if (!isset($iterable[$memberName]) || (gettype($member) !== $memberInfo['type'])) {
                $faults[] = $memberName;
            }
        }
        if (count($faults) > 0) {
            if ($throwErrors) {
                throw new Exception('Invalid fields: ' . implode(',', $faults), 403);
            }
            return false;
        }
        return true;
    }
    /**
     * Undocumented function
     *
     * @return array
     */
    public function serialize()
    {
        $output = [];
        $this->validate();
        $iterable = get_object_vars($this);
        foreach ($this->descriptor as $memberName => $memberInfo) {
            $output[$memberName] = $iterable[$memberName];
        }
        return $output;
    }
}
