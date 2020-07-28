<?php

namespace PayPay\OpenPaymentAPI\Models;

use DateTime;

class UserAuthUrlInfo
{
    /**
     * @var string
     */
    public $aud = "paypay.ne.jp";
    /**
     * @var string
     */
    public $iss = "<merchant organization id>";
    /**
     * @var integer
     */
    public $exp;
    /**
     * @var string
     */
    public $scope = "direct_debit";
    /**
     * @var string
     */
    public $nonce = "";
    /**
     * @var string
     */
    public $redirectUrl;
    /**
     * @var string
     */
    public $referenceId;
    /**
     * @var string
     */
    private $deviceId = null;
    /**
     * @var string
     */
    private $phoneNumber = null;
    /**
     * Payload Info for user authorization
     *
     * @param string $OrgId the merchant name
     * @param DateTime $urlExpiry The expiration date of the authorization page URL. Set with epoch time stamp (seconds).
     * @param string $returnUrl The callback endpoint provided by client. Must be HTTPS, and its domain should be in the allowed authorization callback domains.
     * @param string $userReference The id used to identify the user in merchant system. It will be stored in the PayPay db for reconsilliation purpose.
     */
    public function __construct($OrgId, $urlExpiry, $returnUrl, $userReference)
    {
        $this->nonce = GetRand(16);
        $this->iss = $OrgId;
        $this->exp = $urlExpiry->getTimestamp();
        $this->redirectUrl = $returnUrl;
        $this->referenceId = $userReference;
    }


    /**
     * Returns model data as array
     *
     * @return mixed
     */
    public function serialize()
    {
        return get_object_vars($this);
    }

    /**
     * Set the value of deviceId
     * @param string $deviceId
     * @return  self
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Set the value of phoneNumber
     * @param string $phoneNumber
     * @return  self
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of nonce
     * @return string
     */
    public function getNonce()
    {
        return $this->nonce;
    }
}
