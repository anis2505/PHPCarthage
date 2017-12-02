<?php
namespace System\Libs\Cache;

use System\Libs\Cache\Exceptions\APCCacheException;

class APCCache implements CacheInterface
{
	
	
	protected $isAPCEnabled;
	protected $cacheTime;
	
	
	public function __construct($config)
	{
		$this->cacheTime = $config['cache_time'];
		$this->loadAPC();
	}
	
	private function loadAPC()
	{
		$this->isAPCEnabled = extension_loaded('apc');
		if(!$this->isAPCEnabled)
			throw new APCCacheException("APC Cache not enabled in this server");
	}
	
	// get data from memory
	function get($key)
	{
		$isOK = false;
		$data = \apc_fetch($key, $isOK);
		return ($isOK) ? $data :null;
	}
	
	// save data to memory
	function set($key, $data)
	{
		return \apc_store($key, $data, $this->cacheTime);
	}
	
	// delete data from memory
	function remove($key)
	{
		return (\apc_exists($key)) ? \apc_delete($key) : true;
	}
	
	
	
}