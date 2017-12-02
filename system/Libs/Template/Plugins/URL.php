<?php
namespace System\Libs\Template\Plugins;

/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/11/15
 * Time: 1:18 AM
 */

use System\Helpers\URLHelper;
use System\Libs\Template\PluginInterface;

class URL implements PluginInterface
{
    public function init( &$template )
    {
        $template->register('uri', $this, 'uri');
        $template->register('route', $this, 'route');
        $template->register('hardroute', $this, 'hardroute');
        $template->register('redirect', $this, 'redirect');
        $template->register('hardredirect', $this, 'hardredirect');
    }

    public function uri($callback, $action='', $params=array(), $fullURL = false )
    {
        return URLHelper::_URI($callback, $action, $params, $fullURL);
    }
    
    public function hardroute($controller, $action ='', $params = array())
    {
        return URLHelper::hardRoute($controller,$action,$params);
    }
    
    public function route($routeName, $params = array())
    {
        return URLHelper::route($routeName,$params);
    }
    
    public function redirect($routeName, $params = array())
    {
        URLHelper::redirect($routeName, $params);
    }
    
    public function hardredirect($controller, $action ='', $params = array())
    {
        URLHelper::hardRedirect($controller,$action, $params);
    }
    


} 