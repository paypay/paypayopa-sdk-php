<?php

/**
 * Makes Http Request calls
 *
 * @param String $method Type of HTTP request
 * @param String $url Request URL
 * @param array|boolean $URLparams URL/GET Parameters to added
 * @param array|boolean $body Request Body/POST Payload
 * @param array $options Request options
 * @return string|false — a JSON encoded string on success or FALSE on failure.
 */
function HttpRequest($method, $url, $URLparams = false, $body = false, $options = [])
{
    $curl = curl_init();
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    if ($URLparams) {
        /** @phpstan-ignore-next-line */
        $url .= "?" . http_build_query($URLparams);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    foreach ($options as $OptName => $OptValue) {
        if ($OptName == 'HEADERS') {
            $headerArr = [];
            foreach ($OptValue as $HeaderKey => $HeaderValue) {
                $headerArr[] = "$HeaderKey: $HeaderValue";
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr);
        } else {
            curl_setopt($curl, constant($OptName), $OptValue);
        }
    }

    curl_setopt($curl, CURLOPT_HEADER, 1);
    $response = false;
    switch ($method) {
        case 'GET':
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            break;
        case 'POST':
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if ($body) {
                /** @phpstan-ignore-next-line */
                if (count($body) > 0) {
                    /** @phpstan-ignore-next-line */
                    curl_setopt($curl, CURLOPT_POST, $body ? count($body) : 0);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                }
            }
            $response = curl_exec($curl);
            break;
        case 'PATCH':
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if ($body) {
                /** @phpstan-ignore-next-line */
                if (count($body) > 0) {
                    /** @phpstan-ignore-next-line */
                    curl_setopt($curl, CURLOPT_POST, $body ? count($body) : 0);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                }
            }
            $response = curl_exec($curl);
            break;
        case 'PUT':
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if ($body) {
                /** @phpstan-ignore-next-line */
                if (count($body) > 0) {
                    /** @phpstan-ignore-next-line */
                    curl_setopt($curl, CURLOPT_POST, $body ? count($body) : 0);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                }
            }
            break;
        case 'DELETE':
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if ($body) {
                /** @phpstan-ignore-next-line */
                if (count($body) > 0) {
                    /** @phpstan-ignore-next-line */
                    curl_setopt($curl, CURLOPT_POST, $body ? count($body) : 0);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                }
            }
            $response = curl_exec($curl);
            break;

        default:
            throw new Exception("Invalid HTTP Request");
    }
    if (!$response || curl_errno($curl)) {
        throw new Exception("Invalid response from Server " . curl_error($curl));
    }
     /** @phpstan-ignore-next-line */
    list($Headers) = explode('{', $response?$response:'');
    $headers_arr = explode("\r\n", $Headers);
    /** @phpstan-ignore-next-line */
    $output = str_replace($Headers, '', $response?$response:'');
    $outputData = json_decode($output, true);
    $outputData["transit"] = $headers_arr;
    curl_close($curl);
    return json_encode($outputData);
}
/**
 * HTTP Get
 *
 * @param string $url
 * @param array|boolean $params
 * @param array $options
 * @return string|false — a JSON encoded string on success or FALSE on failure.
 */
function HttpGet($url, $params = false, $options = [])
{
    return HttpRequest('GET', $url, $params, false, $options);
}
/**
 * HTTP Post
 *
 * @param string $url
 * @param array $data
 * @param array $options
 * @return string|false — a JSON encoded string on success or FALSE on failure.
 */
function HttpPost($url, $data, $options = [])
{
    return HttpRequest('POST', $url, false, $data, $options);
}
/**
 * HTTP Patch
 *
 * @param string $url
 * @param array $data
 * @param array $options
 * @return string|false — a JSON encoded string on success or FALSE on failure.
 */
function HttpPatch($url, $data, $options = [])
{
    return HttpRequest('PATCH', $url, false, $data, $options);
}
/**
 * HTTP DElete
 *
 * @param string $url
 * @param array $data
 * @param array $options
 * @return string|false — a JSON encoded string on success or FALSE on failure.
 */
function HttpDelete($url, $data, $options = [])
{
    return HttpRequest('DELETE', $url, false, $data, $options);
}
/**
 * HTTP Put
 *
 * @param string $url
 * @param array $data
 * @param array $options
 * @return string|false — a JSON encoded string on success or FALSE on failure.
 */
function HttpPut($url, $data, $options = [])
{
    return HttpRequest('PUT', $url, false, $data, $options);
}

/**
 * Basic Auth String generator
 *
 * @param string $user
 * @param string $pass
 * @return string — a JSON encoded string on success.
 */
function HttpBasicAuthStr($user, $pass)
{
    $b64 = base64_encode("$user:$pass");
    $b64 = preg_replace("/\s+/", "", $b64);
    $basicAuthStr = "Basic " . $b64;
    return $basicAuthStr;
}
