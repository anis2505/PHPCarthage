<?php
namespace System\Libs\Database\Drivers;



class MysqlDriver
{
    
	public static function getSetup($params)
	{
		extract($params);
		
		return array(
			'dsn' 		=> "mysql:host={$hostname};dbname={$database};charset={$charset}",
			'username'	=>$username,
			'password' 	=> $password
		);
	}

}