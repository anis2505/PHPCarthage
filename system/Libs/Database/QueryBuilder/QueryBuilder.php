<?php
namespace System\Libs\Database\QueryBuilder;

use System\Libs\Database\Exceptions\DatabaseConfigException;

class QueryBuilder
{

	static $operators = [
		'=' 	=> '=',
		'<>' 	=> '<>',
		'<' 	=> '<',
		'>' 	=> '>',
		'<=' 	=> '<=',
		'>=' 	=> '>=',
		'like'	=> 'like',
		'%'		=> '%',
		'?' 	=> '?'
	];
	
	protected $_select 		= [];
	protected $_from 		= [];
	protected $_join 		= [];
	protected $_where 		= [];
	protected $_orderBy 	= [];
	protected $_groupBy 	= [];
	protected $_having 		= [];
	protected $_distinct 	= [];
	protected $_in 			= [];
	protected $_notIn 		= [];
	
	protected $_insert 		= [];
	protected $_values		= [];
	protected $_update 		= [];
	protected $_set			= [];
	protected $_delete 		= [];
	
	protected $_limit 		= null;
	protected $_offset 		= null;
	
	protected $_query 		= '';

	protected $_queryFlag 	= 'select';//'insert','update','delete';
	protected $_whereFlag 	= false;
	protected $_inFlag 		= false;
	 
	
	public static function factory($driver)
	{
		$class = '';
		switch ($driver)
		{
			case 'mysql':
				$class = __NAMESPACE__.'\\MySQLQueryBuilder';
				break;
				
			default:
				throw new DatabaseConfigException('Error Database Configuration');
		}

		return new $class();
		
		
	}
	
	
	public function select($fields = [])
	{
		if(count($fields) == 0)
			$this->_select[] = ['*'];
		else
			$this->_select[] = $fields;
		
		$this->_queryFlag = 'select';
		return $this;
	}
	
	public function from($tables = [])
	{
		$this->_from[] = $tables;
		return $this;
	}
	
	public function join($table, $condition='', $type = 'left')
	{
		$this->_join[] = [$table, $condition, $type];
		return $this;
	}
	
	public function where($conditions = [], $operator = 'AND', $glueOperator='AND')
	{
		$this->_where[] = [$conditions, $operator, $glueOperator];
		return $this;
	}
	
	public function orwhere($conditions = [], $operator = 'AND')
	{
		$this->_where[] = [$conditions, $operator, 'OR'];
		return $this;
	}
	
	public function andwhere($conditions = [], $operator = 'AND')
	{
		$this->_where[] = [$conditions, $operator, 'AND'];
		return $this;
	}
	
	public function orderBy($fields=[], $order)
	{
		$this->_orderBy = [$fields, $order];
		return $this;
	}
	
	public function groupBy($fields=[])
	{
		$this->_groupBy = [$fields];
		return $this;
	}
	
	public function having($conditions = [], $operator = 'AND', $glueOperator='AND')
	{
		$this->_having[] = [$conditions, $operator, $glueOperator];
		return $this;
	}
	
	public function distinct($fields=[])
	{
		$this->_distinct = $fields;
		return $this;
	}
	
	public function in($field, $list=[], $glueOperator = 'AND')
	{
		$this->_in[] = [$field, $list, $glueOperator];
		return $this;
	}
	
	public function notIn($field, $list=[], $glueOperator = 'AND')
	{
		$this->_notIn[] = [$field, $list, $glueOperator];
		return $this;
	}
	
	public function limit($limit, $offset=null)
	{
		$this->_limit = $limit;
		if($offset != null)
			$this->_offset = $offset;
		
		return $this;
	}
	
	public function offset($offset)
	{
		$this->_offset = $offset;
		return $this;
	}

	public function insert($table, $fields = [])
	{
		$this->_insert[] = [$table, $fields];
		
		$this->_queryFlag = 'insert';
		return $this;
	}
	
	public function values($values = [])
	{
		$this->_values[] = $values;
		return $this;
	}
	
	public function update($table)//, $fields = [])//, $conditions = [], $glueOperator = 'AND')
	{
		$this->_update[] = $table;// [$table);//, $fields);//, $conditions, $glueOperator);

		$this->_queryFlag = 'update';
		return $this;
	}
	
	public function set($values = [])
	{
		$this->_set = $values;
		return $this;
	}
	
	public function delete($table)//, $conditions = [], $glueOperator = 'AND')
	{
		$this->_delete[] = [$table];//, $conditions, $glueOperator);

		$this->_queryFlag = 'delete';
		return $this;
	}
	
	public function get()
	{
		if($this->_query == '')
			$this->buildQuery();
		
		return $this->_query;
	}
	
	protected function buildQuery()
	{
		
		
	}
	
	public function init()
	{
		$this->_select 		= [];
		$this->_from 		= [];
		$this->_join 		= [];
		$this->_where 		= [];
		$this->_orderBy 	= [];
		$this->_groupBy 	= [];
		$this->_having 		= [];
		$this->_distinct 	= [];
		$this->_in 			= [];
		$this->_notIn 		= [];
		
		$this->_limit 		= null;
		$this->_offset 		= null;
		
		$this->_insert		= [];
		$this->_values		= [];
		$this->_update 		= [];
		$this->_set			= [];
		$this->_delete 		= [];


		$this->_query 		= '';

		
		return $this;
		
	}
	
	
	
}