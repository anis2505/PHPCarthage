<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/10/15
 * Time: 4:26 PM
 */

namespace System\Libs\Template\Plugins;


use System\Libs\Template\PluginInterface;

use System\DIContainer;

class Translate implements PluginInterface
{

    protected $template;

    public function init(&$template)
    {

        $template->register('_t', $this, 'translate');
    }


    public function translate($msgID='', $default='')
    {

        $localization = DIContainer::getInstance()->get('Localization');

        $translated =  $localization->get( $msgID );

        return (null !== $translated)?$translated : $default;
        
    }



} 