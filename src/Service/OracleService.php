<?php

namespace TrayLabs\OracleStorage\Service;


use GuzzleHttp\Client;

/**
 * Class OracleService
 *
 * @package TrayLabs\OracleStorage\Service
 */
class OracleService
{
    /**
     * @var Client
     */
    protected $client;
    
    /**
     * @var array
     */
    protected $config;
    
    /**
     * OracleService constructor.
     * @param Client $client
     */
    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }
    
}