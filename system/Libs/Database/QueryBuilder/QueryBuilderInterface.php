<?php
namespace System\Libs\Database\QueryBuilder;


interface QueryBuilderInterface
{	
	public function select($fields);
	
	public function from($tables);
	
	public function join($table, $condition, $type);
	
	public function where($conditions, $operator, $glueOperator);
	
	public function orwhere($conditions, $operator);
	
	public function andwhere($conditions, $operator);
	
	public function orderBy($fields, $order);
	
	public function groupBy($fields);
	
	public function having($conditions, $operator, $glueOperator);
	
	public function distinct($fields);
	
	public function in($field, $list);
	
	public function notIn($field, $list);
	
	public function limit($limit, $offset);
	
	public function offset($offset);
	
	public function update($table, $fields = [], $conditions = []);
	
	public function delete($table, $conditions = [], $glueOperator);
	
	
}