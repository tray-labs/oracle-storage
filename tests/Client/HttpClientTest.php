<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use TrayLabs\OracleStorage\Client\HttpClient;


class OracleTest extends TestCase
{
    
    public function testMakeClient()
    {
        $client = HttpClient::make(require(__DIR__ . '/../../config/OracleStorage.php'));
        $this->assertInstanceOf(Client::class, $client);
        $this->assertNotNull($client->getConfig('handler'));
    }
}