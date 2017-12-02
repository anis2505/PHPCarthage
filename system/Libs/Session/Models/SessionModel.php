<?php
namespace System\Libs\Session\Models;

use System\Libs\Database\Model;

use System\Loader;

class SessionModel extends Model
{
    
    
    static $tblName;
    
    public function __construct()
    {
        parent::__construct();
		static::$tblName = Loader::$configs['configs']['session']['handler_params']['db_table'];
        
    }
    
    /**
     * Read
     */
    public function read($id)
    {   
        // Set query
        $query = 'SELECT data FROM '.static::$tblName.' WHERE id = ?';
        return static::$db->query($query,array($id))->asArray()->fetch();
   
    }
    
    /**
     * Write
     */
    public function write($id, $data)
    {   
        // Create time stamp
        $access = time();
        
        // Set query
        $query = 'REPLACE INTO '.static::$tblName.' VALUES (?, ?, ?)';
        
        static::$db->nonQuery($query, array($id, $access, $data));
        
        return true;
        
        
    }
    
    /**
     * Destroy
     */
    public function destroy($id)
    {
        $query = 'DELETE FROM '.static::$tblName.' WHERE id = ?';
        
        static::$db->nonQuery($query, array($id));
        
        return true;
        
    }
    
    /**
     * Garbage Collection
     */
    public function clear($max)
    {
        // Calculate what is to be deemed old
        $old = time() - $max;
        
        $query = 'DELETE FROM '.static::$tblName.' WHERE access = ?';
        
        static::$db->nonQuery($query, array($old));
        
        return true;
        
        
    }
}

