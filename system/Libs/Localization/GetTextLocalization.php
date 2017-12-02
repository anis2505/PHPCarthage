<?php
namespace System\Libs\Localization;

use System\Loader;


class GetTextLocalization
{
    
    public function __construct($config, $lang=null)
	{
	    
		$this->config = $config;
		$this->lang = $lang;
		$this->loadConfigs();
		$this->setLocalization();
	}
	
	private function loadConfigs()
	{
		$this->folder 			= $this->config['folder'];
		$this->enabled 			= $this->config['enabled'];
		$this->localeLanguage 	= $this->config['locales'][$this->lang];
		$this->encoding 		= $this->config['encoding'];
		$this->locale			= $this->localeLanguage.'.'.$this->encoding;
		$this->domain 			= $this->config['domain'];
		$this->localeFullPath 	= APP_PATH.DS.$this->folder;
	}
	
	private function setLocalization()
	{
		putenv('LC_ALL='.$this->locale);
		setlocale(LC_ALL, $this->locale);
		bindtextdomain($this->domain, $this->localeFullPath);
		bind_textdomain_codeset($this->domain, $this->encoding);
		textdomain($this->domain);
	}

    public function get($msgID)
    {
        return gettext($msgID);
    }
	
	
}