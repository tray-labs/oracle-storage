<?php

namespace TrayLabs\OracleStorage\Auth\Storage;


class SessionStorage implements StorageInterface
{
    
    protected $namespace = 'oracle_cloud_storage_token';
    protected $data = [];
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
        return $this->data;
//        return (isset($_SESSION[$this->namespace])) ? $_SESSION[$this->namespace] : null;
    }
    
    /**
     * Method white the X-Auth-Token
     *
     * @param $params
     * @return mixed
     */
    public function write($uri, $token)
    {

        $this->data = [
            'uri' => $uri,
            'token' => $token
        ];

        $_SESSION[$this->namespace] = [
            'uri' => $uri,
            'token' => $token
        ];
    }
}