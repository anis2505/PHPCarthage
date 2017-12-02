<?php
namespace System\Libs\Database\Drivers;



class MysqlDriver
{
    
	public static function getSetup($params)
	{
		extract($params);
		return 'mysql://'.$username.':'.$password.'@'.$hostname.'/'.$database.'?charset='.$charset;
	}

}