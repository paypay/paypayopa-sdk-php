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
            parent::__construct($resultInfo['code'], $code);
            $this->resultInfo = $resultInfo;
            $code = $resultInfo["code"];
            $codeId = $resultInfo["codeId"];
            $apiName = $this->apiInfo["api_name"];
            echo "This link helps you to troubleshoot the issue: ${documentationUrl}?api_name=${apiName}&code=${code}&code_id=${codeId}";
        }
        if (gettype($resultInfo) === 'string') {
            // If string message error
            parent::__construct($resultInfo, $code);
            echo "$resultInfo";
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
