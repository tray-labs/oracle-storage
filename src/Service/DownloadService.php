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
        
        if (!empty($this->config['storage']['cache']) && $this->config['storage']['cache'] && file_exists($filePath)) {
            return $filePath;
        }
        
        $response = $this->client->get('/' . $this->config['storage']['container'] . '/' . $objectName, ['sink' => $filePath]);
        
        if ($response->getStatusCode() == 200) {
            return $filePath;
        }
        
        return false;
    }
}
