<?php

namespace PayPay\OpenPaymentAPI\Models;

use Exception;
use mageekguy\atoum\asserters\integer;

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
     * @param integer $strlen
     * @return void
     */
    protected function _memberize($name, $type, $strlen = 0)
    {
        $this->descriptor[$name] = ['type' => $type, 'strlen' => $strlen];
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
            if ($memberInfo['type'] == 'string') {
                if (strlen($member) < 1) {
                    throw new ModelException("${memberName} cannot be empty", 1,[$memberName]);
                }
                if (isset($memberInfo['strlen']) && $memberInfo['strlen'] != 0 && strlen($member) > $memberInfo['strlen']) {
                    throw new ModelException("${memberName} exceeds maximum size of  characters", 1,[$memberName]);
                }
            }
        }
        if (count($faults) > 0) {
            if ($throwErrors) {
                throw new ModelException('Invalid fields: ' . implode(',', $faults), 403,$faults);
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
