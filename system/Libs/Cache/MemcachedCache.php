<?php
namespace System\Libs\Cache;

use system\Libs\Cache\Exceptions\MemCachedException;

class MemcachedCache implements CacheInterface
{
	
	
	protected $cacheTime; // Time To Live
	protected $isMemCacheEnabled = false; // Memcache enabled?
	protected $oCache = null;
	
		// constructor
	function __construct($config)
	{
		extract($config);
		$this->cacheTime = $config['cache_time'];
		$this->loadMemCache($hostname, $port);
	}
	
	private function loadMemCache($hostname, $port)
	{
		if (class_exists('Memcache'))
		{
			$this->oCache = new \Memcache();
			$this->isMemCacheEnabled = true;
			if (! $this->oCache->connect($hostname, $port))  // Instead 'localhost' here can be IP
			{
				$this->oCache = null;
				$this->bEnabled = false;
			}
		}
		else
		{
			throw new MemCachedException("MemCache not available in this server");
		}
	}

	// get data from cache server
	function get($key)
	{
		$data = $this->oCache->get($key);
		return false === $data ? null : $data;
	}

	// save data to cache server
	function set($key, $data)
	{
		//Use MEMCACHE_COMPRESSED to store the item compressed (uses zlib).
		return $this->oCache->set($key, $data, 0, $this->cacheTime);
	}

	// delete data from cache server
	function remove($key)
	{
		return $this->oCache->delete($key);
	}
	
}