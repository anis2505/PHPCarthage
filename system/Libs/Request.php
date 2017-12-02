<?php
namespace System\Libs;

class Request
{

	private $post;
	private $query;

	public function __construct()
	{
		$this->post = array_merge(array(),$_POST);
		//$this->post = array_filter($_POST,array($this, 'trimValue'));
		$this->query = array_merge(array(),$_GET);
		//$this->query = array_filter($_GET,array($this, 'trimValue'));
	}

	public function getQuery($name=null)
	{
	    if(null == $name)
	        return $this->query;
	    
		if(isset($this->query[$name]))
			return $this->query[$name];
	}

	public function getPost($name=null)
	{
	    if(null == $name)
	        return $this->post;
	    
		if(isset($this->post[$name]))
			return $this->post[$name];
	}

	private function trimValue($value)
	{
	    if(is_string($value))
	       return trim($value);//,'/');
	    
	    if(is_array($value))
	        return array_filter($value,array($this, 'trimValue'));
	}



}