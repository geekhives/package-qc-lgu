<?php
namespace Geekhives\Cimb\Services\Loan;

use Geekhives\Cimb\Services\Helpers\CurlRequestTrait;
use Geekhives\Cimb\Services\Base\BaseRepository;

class CreateToken extends BaseRepository
{
    use CurlRequestTrait;
    /**
     * CashIn constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->resource = 'create_token';
    }
    /**
     * Send the cashin to partner
     *
     * @param array $data
     * @return array
     *
     * @throws Exception
     */
    public function process(array $data)
    {
        try {
            $response = $this->sendRequest(
                $this->buildUrl . $this->resource,
                'POST',
                $data,
                [
                    "Content-Type: application/json",
                    "API-Key: ".$this->apiKey
                ]
            );
            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}