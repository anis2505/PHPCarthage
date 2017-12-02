<?php
namespace System\Libs\Localization;

use System\Loader;
use System\Libs\Localization\Exceptions\LocaliztionFolderNotFoundException;
use System\Libs\Localization\Exceptions\LocalizationLanguageFileNotFound;

class ArrayLocalization
{
    private $lang;
    private $folder;
    private $currentFolder;
    public static $data = array();
    public static $config = array();
    public $enabled;
    
    
    public function __construct($config, $lang = null)
    {
        static::$config = $config;
        
        $this->setLocaleFolder();
        
        if(null == $lang)
            $lang = $this->config['default_lang'];
        
        $this->lang = static::$config['locales'][$lang];
        
        $this->setLocaleLang();
        
    }
    
    private function setLocaleFolder()
    {
        if(! is_dir($this->folder = APP_PATH.DS.static::$config['folder']))
            throw new LocaliztionFolderNotFoundException('The localization folder '.$this->folder.' was not found');
    }
    
    private function setLocaleLang()
    {
        if(! is_dir($this->currentFolder = $this->folder.DS.$this->lang))
            throw new LocaliztionFolderNotFoundException('The localization folder '.$this->currentFolder.' was not found');
    }
    
    public function get($msgID)
    {
        $params = explode('@',$msgID);
        
        if(! isset(static::$data[$params[0]]))
        {
            $langFile = $this->currentFolder.DS.strtr($params[0], '.', DS).'.php';
            
            if( !file_exists($langFile))
                throw new LocalizationLanguageFileNotFound('The localization file '.$langFile.' was not found');
            
            static::$data[$params[0]] = include_once($langFile);
        }
        
        
        if(key_exists($params[1], static::$data[$params[0]]))
            return static::$data[$params[0]][$params[1]];
        
        return null;
  
    }
    
}