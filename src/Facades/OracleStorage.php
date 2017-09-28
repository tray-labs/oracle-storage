<?php

namespace TrayLabs\OracleStorage\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;
use TrayLabs\OracleStorage\OracleStorage as OracleClass;

/**
 * Class OracleStorage
 * @package TrayLabs\OracleStorage\Facades
 */
class OracleStorage extends LaravelFacade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return OracleClass::class;
    }
}