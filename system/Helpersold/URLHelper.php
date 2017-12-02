<?php
namespace System\Helpers;

use System\Libs\Session\Session;

class URLHelper
{
    public static function URI($controller, $action='', $params=array(), $fullURL=false)
    {
        $session = Session::getInstance();
        $carray  = explode(':', $controller);
        $carray = array_map('Sys\Helpers\StringHelper::PascalCase2Underscore',$carray);
        $carray = array_map('strtolower',$carray);
        //$url = "";//INDEX_NAME;
        //if($fullURL)
            $url = BASE_URL.'/'.INDEX_NAME;//.'/'.$url;
        if($session->localization!==null)
            $url .='/'.$session->localization['lang'];
        $action = ($action!=='')?'/'.$action:'';
        $parameters = (count($params))?'/'.implode($params):'';
        $url.='/'.implode('/',$carray).$action.$parameters;

        return $url;
    }
}