<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 7/27/15
 * Time: 11:26 PM
 */

namespace System\Acl;

use System\Model;

class User extends Model
{

    protected $id = null;
    protected $username;
    protected $password;
    protected $groups = array('anonymous');
    protected $isLoggedIn = false;
    protected $loggingAttemps = 0;
    protected static $tbl='users';


    public function __construct($data = null)
    {
        parent::__construct();
    }


    public function save()
    {
        $query =($this->id==null)?$this->getinsertQuery():$this->getUpdateQuery();
    }

    protected function getinsertQuery()
    {
        $query = "INSERT INTO ".static::$tbl."(username, password,groups) values('".$this->username;

    }

    protected function getUpdateQuery()
    {

    }

    public function load($username, $password)
    {
        $query = 'SELECT * FROM '.self::$tbl;
        
    }




} 