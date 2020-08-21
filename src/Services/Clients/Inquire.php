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
        return $response;
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
        
        if (isset($response->data->status_code)) {
            throw new InquireException("[{$response->data->status_code}] {$response->data->status_message}");
        }
        
        return $response;
    }
}