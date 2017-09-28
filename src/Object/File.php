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
     * @return SplFileObject
     */
    public function getFile():SplFileObject
    {
        return new \SplFileObject($this->location);
    }
    
}