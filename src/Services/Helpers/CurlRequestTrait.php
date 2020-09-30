<?php
namespace Geekhives\Qclgu\Services\Helpers;

use Exception;
use GuzzleHttp\Client;

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
    public function sendRequest($baseUrl, $method, $data = null, $headers = array())
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
    public function curl($baseUrl, $method, $data = null, $headers = array())
    {
        $client = new Client(
            [
                'curl' => array( CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false),
            ]
        );

        try {
            $response = $client->request($method, $baseUrl, [
                'headers' => $headers,
                'json' => $data
            ]);

            $contnents = $response->getBody()->getContents();
            
            return $contnents;
        } catch (\Exception $ex) {
            if ($ex instanceof ConnectException) {
                throw $ex;
            }

            if ($ex instanceof ClientException) {
                if ($contnents = $ex->getResponse()->getBody()->getContents()){
                    $contnents = json_decode($contnents);
                    throw new Exception("[{$contnents->TxnStatus->ReplyCode}] {$contnents->TxnStatus->ReplyText}");
                }
                $response = $ex->getResponse();
                throw new Exception("[{$response->getStatusCode()}] {$response->getReasonPhrase()}");
            } 

            $message = $ex->getMessage();
            throw new Exception("{$ex->getCode()} - {$ex->getMessage()}");
        }    
    }
}
