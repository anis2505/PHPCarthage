<?php
namespace System\Libs\Database;



use System\Libs\Database\Exceptions\DatabaseConfigException;
use System\Loader;


class Database
{
	
	public static $params;
	public static $_instance = null;
	public static $driver;
	
	public static function factory()
	{
		if(static::$_instance != null)
			return static::$_instance;

	    static::$params = Loader::config('database');
	    
		
	    if(ENVIRONMENT =='development')
		{
			static::$driver  = static::$params['dev']['driver'];
			$setups = static::$params['dev'][static::$driver];
		}
	    else if(ENVIRONMENT == 'production')
	    {
	        static::$driver = static::$params['prod']['driver'];
	        $setups = static::$params['prod'][static::$driver];
	        
	    }
	    else if(ENVIRONMENT == 'test')
	    {
	        static::$driver = static::$params['test']['driver'];
	        $setups = static::$params['test'][static::$driver];
	    }

	    $conParams =array();
	    
	    switch (static::$driver)
		{
			case 'mysql':
				$conParams = \System\Libs\Database\Drivers\MysqlDriver::getSetup($setups);
				break;
				
			default:
				throw new DatabaseConfigException('Error Database Configuration');
		}
		
		static::$_instance = new DB($conParams['dsn'], $conParams['username'], $conParams['password']);
		
		return static::$_instance;
	}
	
	
}