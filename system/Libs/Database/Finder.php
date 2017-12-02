<?php
namespace System\Libs\Database;
use System\Libs\Database\Database;
use System\Libs\Database\QueryBuilder\QueryBuilder;

use System\Loader;

class Finder
{
	
	static $builder;
	
	public static function find($db, $table, $fields = [], $conditions = [], $prepare = true)
	{
		$preparedData = [];
		if(isset($conditions[0]) && is_array($conditions[0]))
			$preparedData = $conditions[0];
		else
			$preparedData = $conditions;
		
		if($prepare && ! empty($conditions))
			$preparedData = static::prepareData($conditions);
		
		static::$builder = QueryBuilder::factory(Database::$driver);
		$query = static::$builder->select($fields)->from([$table])->where($preparedData)->get();
		if($prepare)
			return $db->query($query, array_values($conditions))->asArray()->fetchAll();
		else
			return $db->query($query)->asArray()->fetchAll();
	}
	
	public static function One($db, $table, $fields = [], $conditions = [], $prepare = true)
	{
		
		static::$builder = QueryBuilder::factory(Database::$driver);
		
		$preparedData = $conditions;
		
		if($prepare)
			$preparedData = static::prepareData($conditions);
		
		$query = static::$builder->init()->select($fields)->from([$table])->where($preparedData)->limit(1)->get();
		
		if($prepare)
			return $db->query($query, array_values($conditions))->asArray()->fetch();
		else
			return $db->query($query)->asArray()->fetch();
	}
	
	public static function all($db, $table, $fields = [])
	{
		static::$builder = QueryBuilder::factory(Database::$driver);
		$query = static::$builder->select($fields)->from([$table])->get();
		
		return $db->query($query)->asArray()->fetchAll();
	}
	
	public static function findBySql($db, $query, $params = [])
	{
		if(! empty($params))
			return $db->query($query, $params)->asArray()->fetchAll();
		
		return $db->query($query)->asArray()->fetchAll();
	}
	
	
	
	public static function findBy($db,$table, $name, $args)
	{
		
		$parts = explode('_',$name);
		$fields =$args[0];
		$operators = [];
		for($i=2; $i<count($parts); $i++)
		{
			if($i%2!=0)
				$operators[] = $parts[$i];
		}
		static::$builder = QueryBuilder::factory(Database::$driver);
		static::$builder->select($fields)->from([$table]);
		
		$i=0;
		foreach($args[1] as $key=>$value)
		{
			if($i>0)
				static::$builder->where([$key=>'?'],'and',array_shift($operators));
			else
				static::$builder->where([$key=>'?'],'and','and');
			$i++;
		}
		
		$query = static::$builder->get();
		
		return $db->query($query,array_values($args[1]))->asArray()->fetchAll();
		
	}
	
	public static function prepareData($data)
	{
		return array_fill_keys(array_keys($data), '?');
	}
	
	
	
	
}