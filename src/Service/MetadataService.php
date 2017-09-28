<?php

namespace TrayLabs\OracleStorage\Service;
use TrayLabs\OracleStorage\Exception\FileNotFound;

/**
 * Class MetadataService
 *
 * @package TrayLabs\OracleStorage\Service
 */
class MetadataService extends OracleService
{
    
    /**
     * Method delete the object from oracle storage
     *
     * @param string $objectName
     * @return array
     * @throws FileNotFound
     */
    public function handle(string $objectName)
    {
        $response = $this->client->head('/' . $this->config['storage']['container'] . '/' . $objectName);

        if ($response->getStatusCode() != 200) {
            throw new FileNotFound("File not found in the Oracle Cloud");

        }

        $contentType = $response->getHeader('Content-Type');
        $contentLength  = $response->getHeader('Content-Length');
        $lastModified = $response->getHeader('X-Last-Modified-Timestamp');
    
        return [
            'Content-Type' => array_pop($contentType),
            'Content-Length' =>  array_pop($contentLength),
            'X-Last-Modified-Timestamp' =>  array_pop($lastModified),
            'Path' => '/' . $this->config['storage']['container'] . '/' . $objectName
        ];
    }
}