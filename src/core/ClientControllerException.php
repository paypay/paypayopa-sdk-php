<?php

namespace PayPay\OpenPaymentAPI\Controller;

use Exception;

class ClientControllerException extends Exception
{
    private $resultInfo = false;
    private $apiInfo = false;

    /**
     * @param string|bool $apiInfo
     * @param array|string $resultInfo
     * @param int $code
     * @param string|bool $documentationUrl
     */
    public function __construct($apiInfo, $resultInfo, $code = 500, $documentationUrl = false)
    {
        $this->documentationUrl = $documentationUrl;
        $this->apiInfo = $apiInfo;
        if (gettype($resultInfo) === 'array') {
            parent::__construct($resultInfo['message'], $code);
            $this->resultInfo = $resultInfo;
        }
        if (gettype($resultInfo) === 'string') {
            // If string message error
            parent::__construct($resultInfo, $code);
        }
    }

    /**
     * @return string
     */
    public function getResolutionUrl()
    {
        if (!$this->documentationUrl || !$this->apiInfo) {
            return "https://github.com/paypay/paypayopa-sdk-php/issues/new/choose";
        }
        $resultInfo = $this->resultInfo;
        $documentationUrl = $this->documentationUrl;
        $code = $resultInfo["code"];
        $codeId = $resultInfo["codeId"];
        $apiName = $this->apiInfo["api_name"];
        return "${documentationUrl}?api_name=${apiName}&code=${code}&code_id=${codeId}";
    }
}
