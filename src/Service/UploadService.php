<?php

namespace TrayLabs\OracleStorage\Service;

use TrayLabs\OracleStorage\Object\File;

/**
 * Class UploadService
 *
 * @package TrayLabs\OracleStorage\Service
 */
class UploadService extends OracleService
{
    
    /**
     * Method perform the upload file to Oracle Cloud Storage
     * @param string $objectName
     * @param File $file
     *
     * @return bool|string
     */
    public function handle(string $objectName, File $file)
    {
        $response = $this->client->put('/' . $this->config['storage']['container'] . '/' . $objectName, [
            'body' => file_get_contents($file->getFile()->getRealPath())
        ]);

        if ($response->getStatusCode() == 201) {
            return $objectName;
        }
        
        return false;
    }
}