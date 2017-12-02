<?php
namespace System\Libs\Database;


class DBStatement extends \PDOStatement
{
    
    public $dbh;
    
    protected function __construct($dbh) {
        $this->dbh = $dbh;
    }
    
    
    public function asArray()
    {
        $this->setFetchMode(\PDO::FETCH_ASSOC);
        return $this;
    }
    
    
    public function asObject($entity = null)
    {
        
        if(null == $entity)
            $this->setFetchMode(\PDO::FETCH_OBJ);
        else 
            $this->setFetchMode(\PDO::FETCH_CLASS, $entity);
        
        return $this;
    }
    
    
}