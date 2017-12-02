<?php
namespace System\Libs\Database;


class DB extends \PDO
{
	
	public $statment = null;

	protected $fetchMode = \PDO::FETCH_ASSOC;
	protected $fetchClass = null;

	function __construct($dsn, $username="", $password="", $driver_options=[]) {
        
		parent::__construct($dsn,$username,$password, $driver_options);
        
		$this->setAttribute(\PDO::ATTR_STATEMENT_CLASS, ['\\System\\Libs\\Database\\DBStatement', [$this]]);
    }
	
	public function query($query, $params = [])
	{
		$this->statement = $this->prepare($query);
		if(count($params) != 0)
		{
			$this->statement->execute($params);
		}
		else
		{
			$this->statement->execute();
		}
		return $this->statement;
	}

	public function nonQuery($query, $params = [])
	{
		$this->statement = $this->prepare($query);
		if(count($params) != 0)
		{
			return $this->statement->execute($params);
		}
		else
		{
			return $this->statement->execute();
		}
	}

	/*
	public function asObject($class = null) 
	{
		if($class == null)
		{
			$this->fetchMode = \PDO::FETCH_OBJ;
		}
		else
		{
			$this->fetchMode = \PDO::FETCH_CLASS;
			$this->fetchClass = $class;
		}

		return $this;

	}

	public function asArray()
	{
		$this->fetchMode = \PDO::FETCH_ASSOC;
		return $this;
	}

	public function geAll()
	{
	    if($this->fetchMode == \PDO::FETCH_CLASS)
		  $this->statement->setFetchMode($this->fetchMode, $this->fetchClass);
	    else
	      $this->statement->setFetchMode($this->fetchMode);
		
	    return $this->statement->fetch();
	}
	public function get()
	{
	    if($this->fetchMode == \PDO::FETCH_CLASS)
	       $this->statement->setFetchMode($this->fetchMode, $this->fetchClass);
	    else
			$this->statement->setFetchMode($this->fetchMode);
	    
		return $this->statement->fetchAll();

	}
	*/

	


	
	
}