<?php
namespace System;


class Loader
{

    
    static $configs = [];
    
	public static function config($configFile, $defaultValue = false, $save = false)
	{
		$fullPath = APP_PATH.DS.'configs'.DS.$configFile.'.php';
		
		if(file_exists($fullPath))
		{
		    if(! $save)
		        return include($fullPath);
		    
		    static::$configs[$configFile] = include($fullPath);
		    return static::$configs[$configFile];
		}
		
		return $defaultValue;

	}
	
	
	public static function get($filePath, $defaultValue = false)
	{
	    $fullPath = $filePath.'.php';
	    
	    return file_exists($fullPath)?include $fullPath : $defaultValue;
	    
	}






}