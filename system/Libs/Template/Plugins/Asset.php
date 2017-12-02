<?php
namespace  System\Libs\Template\Plugins;
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/10/15
 * Time: 10:39 PM
 */



use  System\Libs\Template\PluginInterface;
use System\Loader;


class Asset implements PluginInterface
{

    public $assetsDir = '';

    public $baseURL = '';

    public function __construct()
    {
        $this->assetsDir = BASE_PATH.DS.strtr(Loader::$configs['configs']['template']['assets_folder'],'/',DS);
        $this->baseURL = rtrim('//'.BASE_URL.'/'.Loader::$configs['configs']['template']['assets_folder'],'/');
    }

    public function init(&$template)
    {
        /**
         * Register the asset method of the Asset class to be used
         * from a template.
         * param1: the name used to call the asset method.
         * param2: the instance of the class holding the method.
         * param3: the real method name
         *
         * param1 & param3 can be different.
         */
        $template->register('asset', $this, 'asset');

        $template->register('css', $this, 'css');

        $template->register('js', $this, 'js');
    }


    public function asset( $file='' )
    {
        return $this->assetsDir.DS.strtr($file, '/', DS);
        /*$path = $this->assetsDir.DS.str_replace('/',DS,$file);
        
        if(file_exists($path))
            return $this->baseURL.'/'.$file;
        return '';
        */
    }

    public function css( $file, $method = '' )
    {
        $path = $this->baseURL.'/'. ltrim( $file, '/' );

        $link='';

        switch( $method )
        {
            case 'import':
                $link='@import "'.$path.'"';
                break;
            default:
                $link='<link rel="stylesheet" type="text/css" href="'.$path.'">';
        }
        return $link;
    }

    public function js( $file )
    {
        $path = $this->baseURL.'/'. ltrim($file,'/');
        return '<script type="text/javascript" src="'.$path.'"></script>';
    }

} 
