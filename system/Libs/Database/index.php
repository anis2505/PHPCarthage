<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__.'/QueryBuilder/MySQLQueryBuilder.php';

$builder = new MySQLQueryBuilder();

$builder->select()
		->from(array('user u','code c'))
		->join('posts p', 'u.id=p.user')
		->where(array('u.id <> c.id','u.name=?'))
		->where(array('c.matricule=?'),'or')
		->groupBy(array('username','age'))
		->having(array('username="aaaaa"'))
		->orderBy(array('id'),'DESC')
		->limit(2, 10)
		->in('age',array(1,2,3));

echo 'Query: '.$builder->get();

$builder->init()->insert('users',array('id'=>12, 'name'=>'"a name"', 'dob'=>'"12-06-2000"'));

echo '<br/>Insert: '.$builder->get();

$builder->init()->update('users',array('name'=>'"a name"', 'dob'=>'"12-06-2000"'),array(array('id=12','username="anis255"')));

echo '<br/>Update: '.$builder->get();

$builder->init()->delete('users',array('id=12','username="anis255"'),'OR');

echo '<br/>Delete: '.$builder->get();