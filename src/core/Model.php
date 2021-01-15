<?php

namespace PayPay\OpenPaymentAPI\Models;

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
     * @throws ModelException
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
            if ($memberInfo['type'] === 'string') {
                if (strlen($member) < 1) {
                    throw new ModelException("${memberName} cannot be empty", 1, [$memberName]);
                }
                if (isset($memberInfo['strlen']) && $memberInfo['strlen'] !== 0 && strlen($member) > $memberInfo['strlen']) {
                    throw new ModelException("${memberName} exceeds maximum size of  characters", 1, [$memberName]);
                }
            }
        }
        if (count($faults) > 0) {
            if ($throwErrors) {
                throw new ModelException('Invalid fields: ' . implode(',', $faults), 403, $faults);
            }
            return false;
        }
        return true;
    }
    /**
     * Undocumented function
     *
     * @return array
     * @throws ModelException
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
