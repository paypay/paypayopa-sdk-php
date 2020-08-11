<?php
namespace PayPay\OpenPaymentAPI\Controller;

use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Models\AccountLinkPayload;
use \Firebase\JWT\JWT;
class User extends Controller
{
    /**
     * Stores User Auth Id for operations
     *
     * @var string
     */
    private $userAuthorizationId;
    /**
     * Initializes Code class to manage creation and deletion of data for QR Code generation
     *
     * @param Client $MainInstance Instance of invoking client class
     * @param Array $auth API credentials
     */
    public function __construct($MainInstance, $auth)
    {
        parent::__construct($MainInstance, $auth);
    }


    /**
     * Sets user authorization for this controller
     *
     * @param string $userAuthorizationId
     * @return void
     */
    public function setUserAuthorizationId($userAuthorizationId)
    {
        $this->userAuthorizationId = $userAuthorizationId;
    }

    /**
     * Unlink a user from the client
     *
     * @param string|boolean $userAuthorizationId User authorization id. Leave empty if already set.
     * @return mixed
     */
    public function unlinkUser($userAuthorizationId = false)
    {
        if (!$userAuthorizationId) {
            $userAuthorizationId = $this->userAuthorizationId;
        }
        $url = $this->api_url . $this->main()->GetEndpoint('USER_AUTH') . "/$userAuthorizationId";
        $endpoint = 'v2' . $this->main()->GetEndpoint('USER_AUTH') . "/$userAuthorizationId";
        $options = $this->HmacCallOpts('DELETE', $endpoint);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $response = HttpDelete($url, [], $options);
        /** @phpstan-ignore-next-line */
        return json_decode($response, true);
    }

    /**
     * Create a ACCOUNT LINK QR and display it to the user
     *
     * @param AccountLinkPayload $payload
     * @return void
     */
    public function createAccountLinkQrCode($payload)
    {
        $url = $this->api_url . $this->main()->GetEndpoint('SESSIONS');
        $url = str_replace('v2','v1',$url);
        $endpoint = 'v1' . $this->main()->GetEndpoint('SESSIONS');
        $data = $payload->serialize();
        $options = $this->HmacCallOpts('POST', $endpoint, 'application/json;charset=UTF-8;', $data);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
                
        $options['CURLOPT_TIMEOUT'] = 10;
        if ($data) {
            /** @phpstan-ignore-next-line */
            return json_decode(HttpPost($url, $data, $options), true);
        }
    }
    /**
     * Decode User Authorization data from token after user is redirected back
     *
     * @param string $encodedString
     * @return array
     */
    public function decodeUserAuth($encodedString)
    {
        $key = base64_encode($this->auth['API_SECRET']);
        $decoded = (array) JWT::decode($encodedString, $key, array('HS256'));
        return $decoded;
    }
    /**
     * Get the authorization status of a user
     *
     * @param string $userAuthorizationId
     * @return mixed
     */
    public function getUserAuthorizationStatus($userAuthorizationId)
    {
        if (!$userAuthorizationId) {
            $userAuthorizationId = $this->userAuthorizationId;
        }
        $url = $this->api_url . $this->main()->GetEndpoint('USER_AUTH');
        $endpoint = '/v2' . $this->main()->GetEndpoint('USER_AUTH');
        $options = $this->HmacCallOpts('GET', $endpoint);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $response = HttpGet($url, ['userAuthorizationId' => $userAuthorizationId], $options);
        /** @phpstan-ignore-next-line */
        return json_decode($response, true);
    }

    /**
     * Get the masked phone number of the user
     *
     * @param string $userAuthorizationId
     * @return mixed
     */
    public function getMaskedUserProfile($userAuthorizationId)
    {
        if (!$userAuthorizationId) {
            $userAuthorizationId = $this->userAuthorizationId;
        }
        $url = $this->api_url . $this->main()->GetEndpoint('USER_PROFILE_SECURE');
        $endpoint = '/v2' . $this->main()->GetEndpoint('USER_PROFILE_SECURE');
        $options = $this->HmacCallOpts('GET', $endpoint);
        $mid = $this->main()->GetMid();
        if ($mid) {
            $options["HEADERS"]['X-ASSUME-MERCHANT'] = $mid;
        }
        $response = HttpGet($url, ['userAuthorizationId' => $userAuthorizationId], $options);
        /** @phpstan-ignore-next-line */
        return json_decode($response, true);
    }
}
