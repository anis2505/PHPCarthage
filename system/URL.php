
<?php
namespace \System;


require APP_PATH.DS.'configs'.DS.'configs.php';

class URL
{


	public function getURI()
	{
		$full_url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$uri = rtrim(str_replace(rtrim($base_url,'/').'/'.$index_name, '', $full_url),'/');

		return $uri;

	}




}