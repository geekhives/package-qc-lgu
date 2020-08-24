<?php
namespace Geekhives\Qclgu\Services\Clients;

use Geekhives\Qclgu\Services\Base\BaseRepository;
use Geekhives\Qclgu\Services\Helpers\CurlRequestTrait;
use Geekhives\Qclgu\Services\Clients\Exceptions\InquireException;

class Inquire extends BaseRepository
{
    use CurlRequestTrait;
    /**
     * CashIn constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (!config('package_qc_lgu.base_url')) {
            throw new InquireException('Config base url not set.');
        }
        $this->resource = 'inquire';
    }
    /**
     * Send the cashin to partner
     *
     * @param array $data
     * @return array
     *
     * @throws InquireException
     */
    public function post($referenceNo)
    {
        $accessToken = $this->getAccessToken();
        // $response ='{"reference_number":"A0-09CB8-00001","status_code":"A0","status_message":"Ongoing","amount_to_pay":"3469.1"}';
        
        try {
            $response = $this->curl(
                $this->buildUrl . $this->resource,
                'POST',
                [
                    "reference_no" => $referenceNo,
                    "access_token" => $accessToken,
                ],
                [
                    "Content-Type: application/json"
                ]
            );
        } catch (\Throwable $e) {
            throw new InquireException($e->getMessage());
        }
          
        return $this->parseResponse($response);
    }

    private function getAccessToken()
    {
        if (!$accessToken = config('package_qc_lgu.access_token')) {
            throw new InquireException('Access token not set.');
        }

        return $accessToken;
    }

    private function parseResponse($response)
    {
        
        $response = json_decode($response);
        
        if (in_array($response->status_code, ['C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7'])) {
            throw new InquireException("[{$response->status_code}] {$response->status_message}");
        }
        
        return $response;
    }
}