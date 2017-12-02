<?php
namespace System;

/**
 * 
 * @author anis
 * 
 * Dependancy injection container
 *
 */

use System\Exceptions\DI\ServiceNotFoundException;



class DIContainer //implements \ArrayAccess
{
    
    private static $services = [];
    private static $instances = [];
    private static $singletonMethod = "getInstance";
    
    public static $_instance = null;
    
    
    private function __construct()
    {
        static::loadDependencies();
        
        static::$instances['DIContainer'] = $this;
    }
    
    public static function getInstance()
    {
        if(static::$_instance == null)
            static::$_instance = new DIContainer();
            
        return static::$_instance;
    }
    
    
    private static function loadDependencies()
    {
        //Loading dependacies from config files
        
        $systemServices = Loader::get(SYS_PATH.DS.'configs'.DS.'services', []);
        $userServices   = Loader::config('services', []);
        
        static::$services = array_merge($systemServices, $userServices);
        
    }
    
    
    public function get($className)
    {
        
        if(key_exists($className, static::$instances))
        {
            return static::$instances[$className];
        }
        
        if(! key_exists($className, static::$services)
            or ! class_exists(static::$services[$className]))
        {
            throw new ServiceNotFoundException('The service "'.$className.'" was not found');
        }
        
        $class = static::$services[$className];
        
        $reflectedClass = new \ReflectionClass($class);
        
        if($reflectedClass->isInstantiable())
        {
            $constructor = $reflectedClass->getConstructor();
            
            if(! $constructor)
            {
                static::$instances[$className] = $reflectedClass->newInstance();
            }
            else
            {
                $params = $this->getMethodParams($constructor);
                static::$instances[$className] = $reflectedClass->newInstanceArgs($params);
            }

            return static::$instances[$className];
        }
        
        if($reflectedClass->hasMethod(static::$singletonMethod))
        {
            $reflectedMethod = $reflectedClass->getMethod(static::$singletonMethod);
            
            if(! $reflectedMethod)
                return null;
            
            $params = $this->getMethodParams($reflectedMethod);
            static::$instances[$className] = $reflectedMethod->invokeArgs(null, $params);
            
            return static::$instances[$className];
        }
        
        return null;

    }
    
    private function getMethodParams(\ReflectionMethod $method)
    {
        $params = [];
        
        $parameters = $method->getParameters();
        
        foreach($parameters as $parameter)
        {
            
            if( $parameter->getClass() )
            {
                $params[] = $this->get($parameter->getClass()->getName());
            }
            else if($parameter->isOptional())
            {
                $params[] = $parameter->getDefaultValue();
            }
            else
            {
                $params[] = null;
            }
            
        }
        
        return $params;
        
    }
    
    public function set($className, $class)
    {
        static::$instances[$className] = $class;
    }
    
    public function offsetSet($offset, $value)
    {
        static::$services[$className] = $class;
        
        /*if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }*/
    }

    public function offsetExists($offset) {
        return isset(static::$services[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset(static::$services[$offset]);
    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }
    
}

