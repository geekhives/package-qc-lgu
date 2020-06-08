<?php


namespace Geekhives\QcLgu\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use http\Env\Request;

class Api
{
    /**
     * @var \Illuminate\Config\Repository
     */
    private $tokenPayload;

    /**
     * @var \Illuminate\Config\Repository
     */
    private $baseUrl;

    /**
     * @var \Illuminate\Config\Repository
     */
    private $inquirePayload;

    /**
     * @var Client
     */
    private $client;

    /**
     * Api constructor.
     */
    public function __construct()
    {
        $this->baseUrl = config('package_qc_lgu.baseUrl');
        $this->tokenPayload = config('package_qc_lgu.token_payload');
        $this->inquirePayload = config('package_qc_lgu.inquire_payload');
        $this->client = new Client([
            'headers' => ['Content-Type: application/json']
        ]);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function createToken()
    {
        try {
            $segment = 'index.php/rpt_payment_api/create_token';
            $request = $this->client->request('POST', $this->baseUrl.$segment, $this->tokenPayload);

            $contents = $request->getBody()->getContents();

            $response = [
                'status' => $request->getStatusCode(),
                'response' => $contents
            ];

            dd($contents);
            return $response;

        } catch (ClientException $e) {
            dd(123);
            $content = $e->getResponse()->getBody()->getContents();
            $response = [
                'status' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($content) ? json_decode($content, 1) : $content
            ];
            return $response;
        }
    }

//    /**
//     * @return array
//     * @throws GuzzleException
//     */
//    public function inquire()
//    {
//        try {
//            self::createToken();
//            $segment = 'index.php/rpt_payment_api/inquire';
//            $request = $this->client->request('POST', $this->baseUrl.$segment, $this->inquirePayload);
//
//            $contents = $request->getBody()->getContents();
//
//            $response = [
//                'status' => $request->getStatusCode(),
//                'response' => $contents
//            ];
//
//            return $response;
//
//        }catch (ClientException $e) {
//            $content = $e->getResponse()->getBody()->getContents();
//            $response = [
//                'status' => $e->getResponse()->getStatusCode(),
//                'response' => json_decode($content) ? json_decode($content, 1) : $content
//            ];
//            return $response;
//        }
//    }
//
//    /**
//     * @return array
//     * @throws GuzzleException
//     */
//    public function payment()
//    {
//        try {
//            $segment = 'index.php/rpt_payment_api/post';
//            $request = $this->client->request('POST', $this->baseUrl.$segment, $this->inquirePayload);
//
//            $contents = $request->getBody()->getContents();
//
//            $response = [
//                'status' => $request->getStatusCode(),
//                'response' => $contents
//            ];
//
//            return $response;
//
//        }catch (ClientException $e) {
//            $content = $e->getResponse()->getBody()->getContents();
//            $response = [
//                'status' => $e->getResponse()->getStatusCode(),
//                'response' => json_decode($content) ? json_decode($content, 1) : $content
//            ];
//            return $response;
//        }
//    }
}
