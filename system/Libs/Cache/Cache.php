<?php
namespace System\Libs\Cache;

use System\Loader;
use System\Libs\Cache\Exceptions\CacheHandlerException;
class Cache
{
	
	static $cacheConfig = null;
    
    private function __construct()
    {
        
    }
    
    
    public static function getInstance($handler = null)
    {
        self::loadCacheConfig();
        
        if(! self::$cacheConfig['cache_enabled'])
            return false;
        
        if(null == $handler or !isset(self::$cacheConfig['handlers'][$handler]))
        {
            $handler = self::$cacheConfig['handler'];
        }
        
        $class = self::$cacheConfig['handlers'][$handler];
            
        if(! class_exists($class))
            throw new  CacheHandlerException("The Caching Class {$handler}: {$class} was not found");
        
        return new $class(self::$cacheConfig);
        	
    	
    }
    
    private static function loadCacheConfig()
    {
    	self::$cacheConfig = Loader::$configs['configs']['cache'];
    }
    
    /*
    private static function checkConfig()
    {
    	if(self::$cacheConfig===null)
    		self::loadCacheConfig();
    }
    */

    public function isCacheEnabled()
    {
    	return self::$cacheConfig['cache_enabled'];
    }
    
    public function LoadCache($cacheName)
    {
          $cacheEnabled = self::$cacheConfig['cache_enabled'];
          
          if($cacheEnabled)
          {  
            $cacheTime = self::$cacheConfig['cache_time'];
            $cacheFolder = self::$cacheConfig['cache_folder'];
            $cacheFile = APP_PATH.DS.$cacheFolder.DS.$cacheName.'.html';
            // Serve from the cache if it is younger than $cachetime
            if (file_exists($cacheFile) && time() - $cacheTime < filemtime($cacheFile)) {
              echo "<!-- Cached copy, generated ".date('H:i', filemtime($cacheFile))." -->\n";
              include($cacheFile);
              return;
            } 
          }
    }
  
  public function BuildCache($cacheName)
  {
      $cacheEnabled = self::$cacheConfig['cache_enabled'];
      if($cacheEnabled)
      {
        $cacheFolder = self::$cacheConfig['cache_folder'];
        $cacheFile = APP_PATH.DS.$cacheFolder.DS.$cacheName.'.html';
        // Cache the contents to a file
        //$oldumask = umask(777);
        $cached = fopen($cacheFile, 'w');
        fwrite($cached, ob_get_contents());
        fclose($cached);
        //umask($oldumask);
      }
  }
    
    
}
