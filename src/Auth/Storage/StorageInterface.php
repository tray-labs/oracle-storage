<?php

namespace TrayLabs\OracleStorage\Auth\Storage;


interface StorageInterface
{
    /**
     * Method read the X-Auth-Token
     *
     * @return mixed
     */
    public function read();
    
    /**
     * Method white the X-Auth-Token
     *
     * @param $params
     * @return mixed
     */
    public function write($uri, $token);
    
}