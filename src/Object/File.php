<?php

namespace TrayLabs\OracleStorage\Object;

use SplFileObject;

/**
 * Class File
 *
 * @package TrayLabs\OracleStorage\Object
 */
class File
{
    
    /**
     * @var string File location
     */
    protected $location;
    
    /**
     * File constructor.
     *
     * @param string $location
     */
    public function __construct(string $location)
    {
        $this->location = $location;
    }


    /**
     * Method return the File
     *
     * @return File|SplFileObject
     */
    public function getFile()
    {
        if (class_exists('\Symfony\Component\HttpFoundation\File\File')) {
            return new \Symfony\Component\HttpFoundation\File\File($this->location);
        }

        return new \SplFileObject($this->location);
    }
    
}