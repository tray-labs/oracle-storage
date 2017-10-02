<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use TrayLabs\OracleStorage\Service\MetadataService;

class MetadataServiceTest extends TestCase
{
    
    public function testMetadata()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => 0])
        ]);
        
        $config = require(__DIR__ . '/../../config/OracleStorage.php');
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $arraykeys = [
            "Content-Type",
            "Content-Length",
            "X-Last-Modified-Timestamp",
            "Path"
        ];

        $service = new MetadataService($client, $config);
        $this->assertEquals($arraykeys, array_keys($service->handle('teste.png')));
    }
}