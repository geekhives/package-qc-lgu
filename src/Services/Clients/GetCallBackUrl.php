<?php
namespace Geekhives\Qclgu\Services\Clients;

use Geekhives\Qclgu\Services\Base\BaseRepository;
use Geekhives\Qclgu\Services\Helpers\CurlRequestTrait;
use Geekhives\Qclgu\Services\Clients\Exceptions\CreateTokenException;
use Geekhives\Qclgu\Services\Clients\Exceptions\GetCallBackUrlException;

class GetCallBackUrl extends BaseRepository
{
    use CurlRequestTrait;
    /**
     * CashIn constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (!config('package_qc_lgu.base_url')) {
            throw new CreateTokenException('Config base url not set.');
        }
        $this->resource = 'get_call_back_url';
    }
    /**
     * Send the cashin to partner
     *
     * @param array $data
     * @return array
     *
     * @throws CreateTokenException
     */
    public function post()
    {
        try {
            $response = $this->curl(
                $this->buildUrl . $this->resource,
                'POST',
                [
                    "app_id" => config('package_qc_lgu.app_id'),
                    "app_secret" => config('package_qc_lgu.app_secret'),
                    "call_back_url" => config('package_qc_lgu.call_back_url')
                ],
                [
                    "Content-Type: application/json"
                ]
            );
        } catch (\Throwable $e) {
            throw new GetCallBackUrlException($e->getMessage());
        }

      
        return $this->parseResponse($response);
    }

    private function parseResponse($response)
    {
        $response = json_decode($response);
        if ($response) {
            throw new GetCallBackUrlException("[]");
        }
        
        return $response;
    }
}