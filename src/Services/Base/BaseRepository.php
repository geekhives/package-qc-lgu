<?php
namespace Geekhives\Qclgu\Services\Base;

abstract class BaseRepository
{
    /**
     * @var string
     */
    protected $resource;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $apiKey;

    /**
     * @var
     */
    protected $buildUrl;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $path;
    public function __construct()
    {
        $this->apiKey   = config('package_qc_lgu.api_key');
        $this->baseUrl  = config('package_qc_lgu.base_url');
        $this->path     = '/index.php/rpt_payment_api/';
        $this->buildUrl = $this->baseUrl . $this->path;
    }
}