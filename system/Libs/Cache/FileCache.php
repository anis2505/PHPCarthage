<?php
namespace System\Libs\Cache;


class FileCache implements CacheInterface
{
	
	protected $cacheTime;
	protected $cacheFolder;
	
	public function __construct($config)
	{
		$this->cacheTime 	= $config['cache_time'];
		$this->cacheFolder 	= $config['cache_folder'];
	}
	
	private function getCacheFilePath($cacheFileName,$ext='html')
	{
		return APP_PATH.DS.$this->cacheFolder.DS.$cacheFileName.'.'.$ext;
	}
	
	public function get($key)
	{
		$cacheFile = $this->getCacheFilePath($key,'cache');
		
		if(file_exists($cacheFile) && time() - $this->cacheTime < filemtime($cacheFile))
		{
			return unserialize( file_get_contents( $cacheFile ) );
		}
		
		return null;
	}
	
	public function set($key, $data)
	{
		$cacheFile = $this->getCacheFilePath($key,'cache');
		file_put_contents( $cacheFile, serialize( $data ) );
	}
	
	
	public function getFullPage($key)
	{
		$cacheFile = $this->getCacheFilePath($key);
		// Serve from the cache if it is younger than $cachetime
		if (file_exists($cacheFile) && (time() - filemtime($cacheFile) <= $this->cacheTime))
			return file_get_contents($cacheFile);// $this->getCacheFileContents($cacheFile);
		
		return null;
	}
	
	private function getCacheFileContents($cacheFile)
	{
		$handle 	= fopen($cacheFile, "r");
		$contents 	= fread($handle, filesize($cacheFile));
		fclose($handle);
		return $contents;
	}
	
	public function setFullPage($key, $data)
	{
		$cacheFile = $this->getCacheFilePath($key);
		file_put_contents($cacheFile, $data);
	}
	
	public function remove($key)
	{
		return $this->deleteCache($key, 'cache');
	}
	
	public function removeFullPage($key)
	{
		return $this->deleteCache($key, 'html');
	}
	
	private function deleteCache($key, $ext)
	{
		$cacheFile = $this->getCacheFilePath($key, $ext);
		return (file_exists($cacheFile))? unlink($cacheFile):true;
	}
	
}