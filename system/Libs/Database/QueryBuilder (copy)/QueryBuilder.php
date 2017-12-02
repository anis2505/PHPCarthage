<?php
namespace System\Libs\Database\QueryBuilder;

use System\Libs\Database\Exceptions\DatabaseConfigException;

class QueryBuilder
{

	static $operators = array(
		'=' 	=> '=',
		'<>' 	=> '<>',
		'<' 	=> '<',
		'>' 	=> '>',
		'<=' 	=> '<=',
		'>=' 	=> '>=',
		'like'	=> 'like',
		'%'		=> '%',
		'?' 	=> '?'
	);
	
	protected $_select 		= array();
	protected $_from 		= array();
	protected $_join 		= array();
	protected $_where 		= array();
	protected $_orderBy 	= array();
	protected $_groupBy 	= array();
	protected $_having 		= array();
	protected $_distinct 	= array();
	protected $_in 			= array();
	protected $_notIn 		= array();
	
	protected $_insert 		= array();
	protected $_update 		= array();
	protected $_delete 		= array();
	
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
	
	
	public function select($fields = array())
	{
		if(count($fields) == 0)
			$this->_select[] = array('*');
		else
			$this->_select[] = $fields;
		
		$this->_queryFlag = 'select';
		return $this;
	}
	
	public function from($tables = array())
	{
		$this->_from[] = $tables;
		return $this;
	}
	
	public function join($table, $condition='', $type = 'left')
	{
		$this->_join[] = array($table, $condition, $type);
		return $this;
	}
	
	public function where($conditions = array(), $operator = 'AND', $glueOperator='AND')
	{
		$this->_where[] = array($conditions, $operator, $glueOperator);
		return $this;
	}
	
	public function orderBy($fields=array(), $order)
	{
		$this->_orderBy = array($fields, $order);
		return $this;
	}
	
	public function groupBy($fields=array())
	{
		$this->_groupBy = array($fields);
		return $this;
	}
	
	public function having($conditions = array(), $operator = 'AND', $glueOperator='AND')
	{
		$this->_having[] = array($conditions, $operator, $glueOperator);
		return $this;
	}
	
	public function distinct($fields=array())
	{
		$this->_distinct = $fields;
		return $this;
	}
	
	public function in($field, $list=array(), $glueOperator = 'AND')
	{
		$this->_in[] = array($field, $list, $glueOperator);
		return $this;
	}
	
	public function notIn($field, $list=array(), $glueOperator = 'AND')
	{
		$this->_notIn[] = array($field, $list, $glueOperator);
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

	public function insert($table, $fields = array())
	{
		$this->_insert[] = array($table, $fields);
		
		$this->_queryFlag = 'insert';
		return $this;
	}
	
	public function update($table, $fields = array(), $conditions = array())
	{
		$this->_update[] = array($table, $fields, $conditions);

		$this->_queryFlag = 'update';
		return $this;
	}
	
	public function delete($table, $conditions = array(), $glueOperator = 'AND')
	{
		$this->_delete[] = array($table, $conditions, $glueOperator);

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
		$this->_select 		= array();
		$this->_from 		= array();
		$this->_join 		= array();
		$this->_where 		= array();
		$this->_orderBy 	= array();
		$this->_groupBy 	= array();
		$this->_having 		= array();
		$this->_distinct 	= array();
		$this->_in 			= array();
		$this->_notIn 		= array();
		
		$this->_limit 		= null;
		$this->_offset 		= null;
		
		$this->_insert		= array();
		$this->_update 		= array();
		$this->_delete 		= array();


		$this->_query 		= '';

		
		return $this;
		
	}
	
	
	
}