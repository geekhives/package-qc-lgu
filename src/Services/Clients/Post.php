<?php
namespace Geekhives\Qclgu\Services\Clients;

use Geekhives\Qclgu\Services\Base\BaseRepository;
use Geekhives\Qclgu\Services\Helpers\CurlRequestTrait;
use Geekhives\Qclgu\Services\Clients\Exceptions\PostException;

class Post extends BaseRepository
{
    use CurlRequestTrait;
    /**
     * CashIn constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (!config('package_qc_lgu.base_url')) {
            throw new PostException('Config base url not set.');
        }
        $this->resource = 'post';
    }
    /**
     * Send the cashin to partner
     *
     * @param array $referenceNo
     * @param array $amountPaid
     * @param array $transactionPate
     * @return array
     *
     * @throws PostException
     */
    public function post($referenceNo, $amountPaid, $transactionPate)
    {
        $accessToken = $this->getAccessToken();
        // $response =  '{"reference_number":"A0-09CB8-00001","status_code":"D0","status_message":"Payment: Successful."}';
        try {
            $response = $this->curl(
                $this->buildUrl . $this->resource,
                'POST',
                [
                    "reference_no"      => $referenceNo,
                    "amount_paid"       => $amountPaid,
                    "transaction_date"  => $transactionPate,
                    "access_token"      => $accessToken,
                ],
                [
                    "Content-Type: application/json"
                ]
            );
        } catch (\Throwable $e) {
            throw new PostException($e->getMessage());
        }
        return $this->parseResponse($response);
        return $response;
    }

    private function getAccessToken()
    {
        if (!$accessToken = config('package_qc_lgu.access_token')) {
            throw new PostException('Access token not set.');
        }

        return $accessToken;
    }

    private function parseResponse($response)
    {
        $response = json_decode($response);
        if (in_array($response->status_code, ['D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9'])) {
            throw new PostException("[{$response->status_code}] {$response->status_message}");
        }
        
        return $response;
    }
}