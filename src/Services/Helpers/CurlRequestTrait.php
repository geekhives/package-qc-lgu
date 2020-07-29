<?php
namespace Geekhives\Cimb\Services\Helpers;

use Exception;

trait CurlRequestTrait
{

    /**
     * Send the request
     *
     * @param $baseUrl
     * @param $method
     * @param array   $headers
     * @param array   $data
     *
     * @return array
     *
     * @throws Exception
     */
    public function sendRequest($baseUrl, $method, $data = null, $headers = array()) : array
    {
        $curl = curl_init();
        $opts = [
            CURLOPT_URL => $baseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $headers
        ];
        curl_setopt_array($curl, $opts);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception($err);
        } else {
            return json_decode($response, true);
        }
    }
}
