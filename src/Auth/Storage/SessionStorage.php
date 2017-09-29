<?php

namespace TrayLabs\OracleStorage\Auth\Storage;


class SessionStorage implements StorageInterface
{
    
    protected $namespace = 'oracle_cloud_storage_token';

    /**
     * SessionStorage constructor.
     */
    public function __construct()
    {
        if (session_id() == '') {
            @session_start();
        }
    }
    
    /**
     * Method read the X-Auth-Token
     *
     * @return mixed
     */
    public function read()
    {
        return (isset($_SESSION[$this->namespace])) ? $_SESSION[$this->namespace] : null;
    }
    
    /**
     * Method white the X-Auth-Token
     *
     * @param $params
     * @return mixed
     */
    public function write($uri, $token)
    {
        return $_SESSION[$this->namespace] = [
            'uri' => $uri,
            'token' => $token
        ];
    }
}