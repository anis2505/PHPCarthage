<?php
namespace System;

define('_VERSION','1.0.0');

class Core
{

	public static $configs;

	public $session;
	public $router;
	public $autoloader;
	public $container;
	
	public function __construct()
	{
		$this->container = DIContainer::getInstance();
		
		$this->router = Router::getInstance();
		
		$this->container->get('Autoloader')->load();
		
		$this->setTimezone();
		
		$this->session = $this->container->get('Session');
		$this->initUser();
		

	}

	public function run()
	{
		$this->serve();
	}

	public function serve()
	{

		$match = $this->router->match();
		
		if( ! $match)
		{
			$this->loadError();
			return;
		}
		
		$this->setLocale($match['locale']);
		
		    
		
		if( is_callable( $match['target'] ) ) 
		{
			call_user_func_array( $match['target'], $match['params'] ); 
			return;
		}
		

		$callbacks = explode('@', $match['target']);
		
		$controller = str_replace('.', '\\', $callbacks[0]);//strtr($callbacks[0], '.', '\\');// 
		$action = count($callbacks)==2 ?$callbacks[1]:'index';
		
		if(class_exists($controller) and method_exists($controller, $action))
		{

			$instance = new $controller($this->container);
			
			if( is_callable(array($instance,$action)))
			    call_user_func_array(array($instance,$action), $match['params']);

			return;
		}

		$this->loadError();

	}
	
	public function initUser()
	{
		$this->container->get('UserManager');
	}
	
	public function setTimezone()
	{
	    date_default_timezone_set(Loader::$configs['configs']['timezone']);
	}
	
	public function setLocale($locale)
	{
	    if(! Loader::$configs['configs']['localization']['enabled'])
	        return;
	    
	    $key = Loader::$configs['configs']['localization']['session_key'];
	    
	    if(null == $locale)
	        $locale = Loader::$configs['configs']['localization']['default_lang'];
	        
	        
	    $this->session->set($key, $locale);
	}
	
	public function loadError()
	{
	    $this->container->get('Template')->render('errors.404');
	}

}
