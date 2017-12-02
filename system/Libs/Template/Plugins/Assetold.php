<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/10/15
 * Time: 10:39 PM
 */

namespace System\Libs\Template\Plugins;

use System\Libs\Template\PluginInterface;

class Asset implements PluginInterface
{

    public function init($template)
    {
        $template->register('asset', $this, 'asset');
        $template->register('css', $this, 'css');
        $template->register('js', $this, 'js');
    }


    public function asset( $file='' )
    {
        $path = BASE_PATH.DS.str_replace('/',DS,$file);

        if(file_exists($path))
            return BASE_URL.'/'.$file;
        return '';
    }

    public function css( $file, $method = '' )
    {
        $path = BASE_URL.'/'. ltrim( $file, '/' );

        $link='';

        switch( $method )
        {
            case 'import':
                $link='@import "'.$path.'"';
                break;
            default:
                $link='<link href="'.$path.'" rel="stylesheet">';
        }
        return $link;
    }

    public function js( $file )
    {
        $path = BASE_URL.'/'. ltrim($file,'/');
        return '<script type="text/javascript" src="'.$path.'"></script>';
    }

} 