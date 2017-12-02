<?php
namespace System\Helpers;

use System\DIContainer;

use System\Router;

class URLHelper
{
    
    public static function route($routeName, $params = array())
    {
        $locale = Router::$router->getLocale();
        return Router::$router->generate($routeName, $params);
        
    }
    
    
    
    public static function hardRoute($controller, $action = '', $params = array())
    {
        $locale = (null != Router::$router->getLocale())?'/'.Router::$router->getLocale():'';
        return '//'.rtrim(BASE_URL.$locale.'/'.$controller.'/'.$action,'/').'/'.implode('/', $params);
    }
    
    
    public static function uri($routeName, $params = array())
    {
        $locale = Router::$router->getLocale();
        return Router::$router->generate($routeName, $params);
        
    }
    
    
    public static function hardUri($controller, $action = '', $params = array())
    {
        $locale = (null != Router::$router->getLocale())?'/'.Router::$router->getLocale():'';
        return rtrim(BASE_URL.$locale.'/'.$controller.'/'.$action,'/').'/'.implode('/', $params);
    }

    
    public static function getURI( $parts = array(), $params=array() )
    {
        if( empty($parts) )
            return '';

        $class = array_shift( $parts );

        if( class_exists( $class ) )
            $class = trim( str_replace('\\','/', $class), '/' );

        $url = BASE_URL.'/'.$class.(count( $parts )>0)?'/'.$parts[1]:'';

        if( ! empty( $params ) )
            $url .= implode('/', $params);

        return $url;

    }

    
    public static function _URI($controller, $action='', $params=array(), $fullURL=false)
    {
        $session = Session::getInstance();
        $controllers  = explode(':', $controller);
        $controllers = array_map('Darwin\Helpers\StringHelper::PascalCase2Underscore',$controllers);
        $controllers = array_map('strtolower',$controllers);
        //$url = "";//INDEX_NAME;
        //if($fullURL)
            $url = BASE_URL.'/'.INDEX_NAME;//.'/'.$url;
        if($session->localization!==null)
            $url .='/'.$session->localization['lang'];
        $action = ($action!=='')?'/'.$action:'';
        $parameters = (count($params))?'/'.implode($params):'';
        $url.='/'.implode('/',$controllers).$action.$parameters;

        return $url;
    }

    
    public static function redirect($routeName, $params=array())
    {
        $url = static::route($routeName, $params);
        echo $url;

        header('Location:'.$url);
    }
    
    
    public static function hardRedirect($controller, $action='', $params=array())
    {
        $url = static::route($controller,$action,$params);
        echo $url;
        
        header('Location:'.$url);
    }

    
    public static function forceDownload($fileType, $fileName, $filePath)
    {
        header('Content-Type: application/'.$fileType);
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        readfile($filePath);
    }

}