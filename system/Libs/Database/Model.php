<?php
namespace System\Libs\Database;


use System\Libs\Database\QueryBuilder\QueryBuilder;
use System\Libs\Database\Finder;
use System\Helpers\ObjectHelper;
use System\Utilities\Inflect;
class Model
{
    
	public static $db = null;
	
	public static $tblName = '';

	public function __construct()
	{
		static::init();
	}
	
	public static function init()
	{
		if(static::$tblName =='')
		{
			$segments = explode('\\', get_called_class());
			$class = array_pop($segments);
			 static::$tblName = Inflect::pluralize(strtolower($class));
		}
		if(null == static::$db)
			static::$db = Database::factory();
	}
	
	public function getData()
	{
		$data =  ObjectHelper::getObjectAsArray($this);
		unset($data['db']);
		return $data;
	}
	
	public function setData($data = [])
	{
		foreach($data as $key=>$value)
		{
			$this->{$key} = $value;
		}
	}	

	public function getBuilder()
	{
		return QueryBuilder::factory(Database::$driver);
	}
	
	public static function find($fields = [], $conditions = [], $prepare = true)
	{
		static::init();
		return Finder::find(Database::factory(),static::$tblName,$fields, $conditions, $prepare);
	}
	
	public static function One($fields = [], $conditions = [], $prepare = true)
	{
		static::init();
		return Finder::One(Database::factory(),static::$tblName,$fields, $conditions, $prepare);
	}
	
	public static function findAll($table, $fields = [])
	{
		static::init();
		return Finder::find(Database::factory(),static::$tblName,$fields);
	}
	
	public static function findBySql($query, $params = [])
	{
		static::init();
		return Finder::findBySql(static::$db, $query, $params);
	}

	public static function __callStatic($name, $args)
	{
		static::init();
		
		if(0===strpos($name,'find_by'))
		{
			return Finder::findBy(static::$db, static::$tblName, $name, $args);
		}
		
		if($name=='getBuilder')
		{
			return QueryBuilder::factory(Database::$driver);
		}
		
	}
	
	
}