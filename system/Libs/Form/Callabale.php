<?php
namespace System\Libs\Form;

class Callabale
{
    
    public function __construct($closure)
    {
        $this->$closure = $closure;
        
    }
    
    public function invoke($params = array())
    {
        if(is_callable($this->closure))
            return call_user_func_array($this->closure, $params);
        
        throw new \Exception('The introduced closure is not callable');
    }
    
}

