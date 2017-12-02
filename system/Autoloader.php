<?php
namespace System;

class Autoloader
{
    static $loads = array();
    
    public function load()
    {
        static::$loads = array_merge(Loader::get(SYS_PATH.DS.'configs'.DS.'autoloads', []), Loader::config('autoloads', []));
        
        foreach(static::$loads as $callback=>$method)
        {
        	call_user_func([$callback, $method]);
            //$callback();
        }
        
    }
    
    
}