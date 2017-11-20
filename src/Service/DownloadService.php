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
        
        $response = $this->client->get('/' . $this->config['storage']['container'] . '/' . $objectName, ['sink' => $this->config['storage']['local_path'] . '/' . $objectName]);
        
        if ($response->getStatusCode() == 200) {
            return $this->config['storage']['local_path'].'/'.$objectName;
        }
        
        return false;
    }
}
