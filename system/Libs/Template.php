<?php
namespace System\Libs;


class Template
{
    
    private $datas = array();
    static $viewsFolder = 'views';
    
    
    public function __construct()
    {
        
    }
    
    public function render($template, $datas=null)
    {
        $template = APP_PATH.DS.static::$viewsFolder.DS.str_replace(".", DS, $template).'.php'; //'Views'.DS.str_replace("/", DS, $template);
        
        ob_start();
        
        if(null !== $datas && is_array($datas))
            $this->datas = array_merge($this->datas,$datas);
        
        extract($this->datas);
        
        $content = file_get_contents($template);
        echo $content;
        ob_end_flush();
        $this->datas = array();
    }
    
    public function set($name, $value)
    {
        $this->variables[$name] = $value;
    }
    
    public function setDatas($datas)
    {
        if(null!==$datas && is_array($datas))
            $this->datas = array_merge($this->datas,$datas);
    }
}