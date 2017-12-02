<?php
namespace System\Libs\Database;

use System\Loader;
use system\Libs\Database\Exceptions\DatabaseConfigException;

class Database
{
    
    static $params = array();

	public function __construct()
	{
	    
	}

	public static function setDB()
	{
	    static::$params = Loader::config('database');
	    
	    $driver  = static::$params['dev']['driver'];
	    
	    //$driverTest = static::$params['test']['driver'];
	    
	    $setups = static::$params['dev'][$driver];
	    
	    if(ENVIRONMENT == 'production')
	    {
	        $driver = static::$params['prod']['driver'];
	        $setups = static::$params['prod'][$driver];
	        
	    }
	    else
	    {
	        
	        $driver = static::$params['test']['driver'];
	        $setups = static::$params['test'][$driver];
	    }
	    $conString ='';
	    switch ($driver)
		{
			case 'mysql':
				$conString = \System\Libs\Database\Drivers\MysqlDriver::getSetup($setups);
				break;
				
			default:
				throw new DatabaseConfigException('Error Database Configuration');
		}
		
		\ActiveRecord\Config::initialize(function($cfg) use(&$conString)
		{
			$cfg->set_model_directory(APP_PATH.DS.'Models');
			$cfg->set_connections(array(ENVIRONMENT => $conString));
			$cfg->set_default_connection(ENVIRONMENT);
		});
	}
	



}

