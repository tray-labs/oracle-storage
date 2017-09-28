<?php

namespace TrayLabs\OracleStorage\Service;

/**
 * Class DeleteService
 *
 * @package TrayLabs\OracleStorage\Service
 */
class DeleteService extends OracleService
{
    
    /**
     * Method delete the object from oracle storage
     *
     * @param string $objectName
     * @return bool
     */
    public function handle(string $objectName):bool
    {
        $response = $this->client->delete('/' . $this->config['storage']['container'] . '/' . $objectName);
        
        if ($response->getStatusCode() == 204) {
            return true;
        }
        
        return false;
    }
}