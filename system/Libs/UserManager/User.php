<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/8/15
 * Time: 6:39 PM
 */

namespace System\Libs\UserManager;

use System\Libs\Database\Model;
use System\Loader;


class User extends Model
{

    /**
     *
     * Fields: id, IP, Username, Password, token
     *
     */

    public $user = null;
    static $tblName;
    
    public function __construct()
    {
        parent::__construct();
		static::$tblName = Loader::$configs['configs']['user']['table'];
        
    }
    public function getData()
	{
        $data = parent::getData();
        unset($data['user']);
        return $data;
    }

    public function checkUser( $data = array() )//$username, $password)
    {
        $result = User::One(array('id','username'),$data);// find_by_username_and_password()
		
		if(! $result)
			return false;
		
		$this->user = new User();
        $this->user->setData($result);
        
		return true;

    }

    public function getUser($fields = array(), $conditions = array())
    {
        $user = User::One($fields, $conditions);
        
        if(! $user)
            return false;
		
		$this->user = new User();
        $this->user->setData($user);
		return $user;
		
	
    }

    public function createUser( $data = array() )
    {
        
        $builder = $this->getBuilder();
        
        $preparedData = array_fill(array_keys($data),'?');
        
        $query = $builder->insert(static::$tblName)->values($preparedData)->get();
        
        return static::$db->nonQuery($query, array_values($data));

    }

    public function deleteUser( $conditions = array() )
    {
        $builder = $this->getBuilder();
		
        $preparedConditions = array_fill(array_keys($conditions),'?');
        
		$query = $builder->delete(static::$tblName)->where($preparedConditions)->get();
        
        static::$db->nonQuery($query, array_values($conditions));

    }

    public function updateUser( $data = array(), $conditions = array() )
    {
        $builder = $this->getBuilder();
		
        $preparedData = array_fill_keys(array_keys($data), '?');
		$preparedConditions = array_fill_keys(array_keys($conditions), '?');
        
		$query = $builder->init()->update(static::$tblName)->set($preparedData)->where($preparedConditions)->get();
		
        return static::$db->nonQuery($query, array_merge(array_values($data),array_values($conditions)));
	
    }

    public function getLastFetched()
    {
        return $this->user;
    }
} 