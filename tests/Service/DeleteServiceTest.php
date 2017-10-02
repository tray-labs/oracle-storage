<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use TrayLabs\OracleStorage\Service\DeleteService;

class DeleteServiceTest extends TestCase
{
    
    public function testDelete()
    {
        $mock = new MockHandler([
            new Response(204, ['Content-Length' => 0])
        ]);
        
        $config = require(__DIR__ . '/../../config/OracleStorage.php');
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $service = new DeleteService($client, $config);
        $this->assertEquals(true, $service->handle('teste.png'));
    }
}