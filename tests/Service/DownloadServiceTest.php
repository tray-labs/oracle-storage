<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use TrayLabs\OracleStorage\Service\DownloadService;

class DownloadServiceTest extends TestCase
{
    
    public function testDownload()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => 1000], file_get_contents((__DIR__) . '/../files/images.png')),
        ]);

        $config = require(__DIR__ . '/../../config/OracleStorage.php');
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $service = new DownloadService($client, $config);
        $this->assertNotNull($service->handle('images.png'));
        $this->assertFileExists($config['storage']['local_path'] . '/' . 'images.png');
        unlink($config['storage']['local_path'] . '/' . 'images.png');
    }
    
}
