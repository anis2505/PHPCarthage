<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/10/15
 * Time: 10:39 PM
 */

namespace System\Libs\Template\Plugins;

use System\Libs\Template\PluginInterface;

class Basic implements PluginInterface
{

    public  $loops = array();

    public function init($template)
    {
        $template->register('loop', $this, 'loop');
        $template->register('end_loop', $this, 'endLoop');
        
    }

    public function loop($items, $key, $value='')
    {
        array_unshift( $this->loops, $items );
        $this->loops[$items] = array($key, $value);
        ob_start();
        //$this->loops($items);
    }

    public function endLoop()
    {
        $loopContent = ob_get_contents();
        ob_get_clean();
        $items = array_shift($this->loops);

        //foreach( ${$items} as $key )

    }

} 