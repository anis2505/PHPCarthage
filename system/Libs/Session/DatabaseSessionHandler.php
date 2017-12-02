<?php
namespace System\Libs\Session;

/**
 * Created by PhpStorm.
 * User: anis
 * Date: 7/24/15
 * Time: 7:50 PM
 */

use System\Libs\Session\Models\SessionModel;// as Model;

class DatabaseSessionHandler implements \SessionHandlerInterface //extends \SessionHandler
{
    /*
        CREATE TABLE IF NOT EXISTS sessions (
          id varchar(32) NOT NULL,
          access int(10) unsigned DEFAULT NULL,
          data text,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


     */

    /**
     * Db Object
     */
    
    public static $dbTable;
    public $model;
    
    public function __construct($dbTable)
    {
        //echo "<br/>DBTable: ".$dbTable.'<br/>';
        //self::$dbTable = $dbTable;
        //$this->model->$tblName = $dbTable;
        //$this->model->init();
        // Instantiate new Database object
        $this->model = new SessionModel();//$dbTable);//$dbTable);
    }

    /**
     * Open
     */
    public function open($save_path, $name)
    {
        return true;
    }

    /**
     * Close
     */
    public function close()
    {
        return true;
    }


    /**
     * Read
     */
    public function read($id)
    {
        $row = $this->model->read($id);
        return isset($row['data'])?$row['data']:null;
        
        
    }

    /**
     * Write
     */
    public function write($id, $data)
    {
        return $this->model->write($id, $data);
        
    }

    /**
     * Destroy
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
        
    }

    /**
     * Garbage Collection
     */
    public function gc($max)
    {
       return $this->model->clear($max);

        
    }


}