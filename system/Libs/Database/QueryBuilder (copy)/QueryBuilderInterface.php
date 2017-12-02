<?php
namespace System\Libs\Database\QueryBuilder;


interface QueryBuilderInterface
{	
	public function select($fields);
	
	public function from($tables);
	
	public function join($table, $condition, $type);
	
	public function where($conditions, $operator, $glueOperator);
	
	public function orderBy($fields, $order);
	
	public function groupBy($fields);
	
	public function having($conditions, $operator, $glueOperator);
	
	public function distinct($fields);
	
	public function in($field, $list);
	
	public function notIn($field, $list);
	
	public function limit($limit, $offset);
	
	public function offset($offset);
	
	public function update($table, $fields = array(), $conditions = array());
	
	public function delete($table, $conditions = array(), $glueOperator);
	
	
}