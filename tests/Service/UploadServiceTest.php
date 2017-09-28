<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use TrayLabs\OracleStorage\Object\File;
use TrayLabs\OracleStorage\Service\UploadService;

class UploadServiceTest extends TestCase
{
    
    public function testUpload()
    {
        $mock = new MockHandler([
            new Response(201, ['Content-Length' => 0])
        ]);
        
        $config = include('src/config/OracleStorage.php');
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $service = new UploadService($client, $config);
        $this->assertEquals('teste.png', $service->handle('teste.png', new File((__DIR__) . '/../files/images.png')));
        
    }
}