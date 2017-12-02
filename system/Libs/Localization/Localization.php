<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/5/15
 * Time: 11:45 AM
 */

namespace System\Libs\Localization;

use System\DIContainer;

use System\Loader;
use System\Libs\Localization\Exceptions\LocalizationHandlerNotFoundException;

class Localization
{
    
    static $_instance = null;
    
    private function __construct()
    {
        
    }
    
    public static function getInstance()
    {
        
        if(static::$_instance != null)
            return static::$_instance;
        
        $params = Loader::$configs['configs']['localization'];
        /*
        if($params['enabled'] == false)
            return null;
        */
        $session = DIContainer::getInstance()->get('Session');
        
        $lang = ($session->get($params['session_key']) != null)?$session->get($params['session_key']):$params['default_lang'];
        
        $handler = $params['handler'];
        
        if(!class_exists($handler))
            throw new LocalizationHandlerNotFoundException('The localization class'.$handler.' was not found');
        
       static::$_instance = new $handler($params, $lang);
            //$class = new \ReflectionClass($params['handler']);
            //static::$_instance = $class->newInstanceArgs(array($params, $lang));
       return static::$_instance;
        
    }


} 