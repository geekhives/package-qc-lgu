<?php
namespace Geekhives\Qclgu\Services\Clients;

use Geekhives\Qclgu\Services\Base\BaseRepository;
use Geekhives\Qclgu\Services\Helpers\CurlRequestTrait;
use Geekhives\Qclgu\Services\Clients\Exceptions\CreateTokenException;

class CreateToken extends BaseRepository
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
        $this->resource = 'create_token';
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
            throw new CreateTokenException($e->getMessage());
        }

        return $response;
    }
}