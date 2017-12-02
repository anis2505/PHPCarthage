<?php
namespace System\Libs;



use System\Loader;
use System\DIContainer;

class Language
{
    
    
    private $lang;
    
    static $messages = array();
    static $params;
    
    public function __construct(DIContainer $container)
    {
        $this->container = $container;
        
        static::$params = Loader::$configs['configs']['localization'];
        
        $this->lang = $this->container->get('Session')->get(static::$params['session_key']);
        
        
        
    }
    
    public function getMessage($fileName, $message)
    {
        
        if(! issset(static::$messages[$this->lang][$fileName]))
        {
            $filePath = DS.'languages'.DS.$this->lang.DS.str_replace('.', DS, $fileName).'.php';
            
            if(file_exists(APP_PATH.$filePath))
            {
                $filePath = APP_PATH.$filePath;
            }
            else if(file_exists(SYS_PATH.$filePath))
            {
                $filePath = SYS_PATH.$filePath;
            }
            else
            {
                return null;
            }
                
            static::$messages[$this->lang][$fileName] = Loader::get($filePath);
            
        }
        
        if(issset(static::$messages[$this->lang][$fileName][$message]))
        {
            return static::$messages[$this->lang][$fileName][$message];
        }
        
        return null;
        
        
    }
    
}

