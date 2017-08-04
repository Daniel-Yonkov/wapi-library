<?php
namespace wapi\handlers;

/**
 * Error Handler
 */
class ErrorHandler
{
	protected static $error;
    /**
     * Error Handling
     */
    private final function __construct()
    {
    	
    }

    public static function fail(array $error){
    	self::$error['errors'][] = $error;
    	$_SESSION=self::$error;
    }
}