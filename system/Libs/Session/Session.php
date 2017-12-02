<?php
namespace System\Libs\Session;

use System\Loader;


class Session
{
    
    static $params;
    
    
	public function __construct()
	{
	    
	    self::$params = Loader::$configs['configs']['session'];
	    
	    $this->initSession();
	}
	
	private function initSession()
	{
	    extract(self::$params);
	    
	    $this->setHandler();
	    
	    $this->setSessionCookie( $lifetime, $cookie_httponly, $cookie_secure_mode, $cookie_domain );
	    
	    $this->startSession( $name );
	    
	}
	
	protected function startSession( $name )
	{
	    session_name($name);
	    session_start();
	}
	
	private function setHandler()
	{
	    if(class_exists(self::$params['handler']))
	    {
	        $class = new \ReflectionClass(static::$params['handler']);
	        $handler = $class->newInstanceArgs(static::$params['handler_params']);
	        session_set_save_handler($handler,true);
	        
	    }	    
	}
	
	protected function setSessionCookie( $lifetime, $cookie_httponly, $cookie_secure_mode, $cookie_domain )
	{
	    // Set the max lifetime
	    ini_set("session.gc_maxlifetime", $lifetime);
	    
	    // Set the session cookie to timout
	    ini_set("session.cookie_lifetime", $lifetime);
	    
	    ini_set( 'session.cookie_httponly', $cookie_httponly );
	    
	    ini_set( 'session.cookie_secure', $cookie_secure_mode );
	    
	    ini_set('session.cookie_domain',$cookie_domain);
	    
	    ini_set('session.use_only_cookies',1);
	}
	
	public function set($key, $value)
	{
	    if($key != null)
	    {
	        $_SESSION[$key] = $value;
	    }
	}

	public function setValues($values)
	{
		if($values!=null && is_array($values))
		{
			foreach ($values as $key => $value)
			{
				$_SESSION[$key] = $value;
			}
		}
	}
	
	public function get($key)
	{
		if(isset($_SESSION[$key]))
			return $_SESSION[$key];
		else
			return null;
	}

	public function remove($key)
	{
		if(isset($_SESSION[$key]))
		{
			unset($_SESSION[$key]);
		}
	}
	
	
	public function getFlash()
	{
	    $flash = $this->get('flash');
	    
	    if( $flash !== null )
	        $this->remove('flash');
	        
	        return $flash;
	}
	
	public function addFlash($key, $value)
	{
	    $flash = $this->get('flash');
	    if($flash===null)
	        $flash = array();
	        $flash[$key] = $value;
	        $this->set('flash', $flash);
	}
	
	public function removeFlash($key)
	{
	    $flash = $this->get('flash');
	    if( $flash !==null && isset($flash[$key]) )
	    {
	        unset($flash[$key]);
	        $this->set('flash', $flash);
	    }
	}
	

	public function clear()
	{
		session_unset();
	}
	
}