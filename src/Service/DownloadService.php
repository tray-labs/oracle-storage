<?php

namespace TrayLabs\OracleStorage\Service;

/**
 * Class DownloadService
 *
 * @package TrayLabs\OracleStorage\Service
 */
class DownloadService extends OracleService
{
    
    /**
     * Method execute the download from oracle storage
     *
     * @param string $objectName
     * @return bool
     */
    public function handle(string $objectName)
    {
        if (!is_dir($this->config['storage']['local_path'])) {
            mkdir($this->config['storage']['local_path'], 0777, true);
        }
    
        $filePath = $this->config['storage']['local_path'] . '/' . $objectName;
        
        $response = $this->client->get('/' . $this->config['storage']['container'] . '/' . $objectName, ['sink' => $filePath]);
        
        if ($response->getStatusCode() == 200) {
            chmod($filePath, 0777);
            return $filePath;
        }
        
        return false;
    }
}
