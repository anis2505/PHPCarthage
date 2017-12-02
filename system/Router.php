<?php
namespace System;

use System\Libs\Routing;

class Router
{
	

	public static $router;

	private static $_instance = null;


	private function __construct()//$base_path)
	{
		static::$router = new Routing(); //\AltoRouter();
		
		$base_path = Loader::$configs['configs']['routing']['router_path'];
		$isHardRoutingEnabled = Loader::$configs['configs']['routing']['hard_routing_enabled'];
		
		$islocaleEnabled = Loader::$configs['configs']['localization']['enabled'];
		$locales =  array_keys(Loader::$configs['configs']['localization']['locales']);
		
		static::$router->setBasePath($base_path);
		static::$router->setLocalization($islocaleEnabled, $locales);
		static::$router->setHardRouting($isHardRoutingEnabled);
		
	}


	public static function getInstance()//$base_path)
	{
		if(null === static::$_instance)
			$_instance = new Router();//$base_path);

		$_instance->load_routes();

		return $_instance;
	}
	


	private function load_routes()
	{
		$routes = Loader::config('routes');

		if(null != $routes)
			static::$router->addRoutes($routes);

	}


	public function match()
	{
		return static::$router->match();
	}







}