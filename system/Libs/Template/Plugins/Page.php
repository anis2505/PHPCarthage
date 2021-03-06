<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/11/15
 * Time: 1:23 AM
 */

namespace System\Libs\Template\Plugins;

use System\Libs\Template\PluginInterface;

class Page implements PluginInterface
{
    protected $template;

    protected $blocks = array();

    public function init( $template )
    {
        $this->template = $template;

        $this->template->register('start_block', $this, 'start_block');
        $this->template->register('end_block', $this, 'end_block');
    }

    public function start_block( $name )
    {
        //$this->addBlock( $name );
        array_unshift( $this->blocks, $name );
        ob_start();
    }

    public function end_block()
    {
        var_dump($this->blocks);
        if( empty( $this->blocks ) )
            return;

        $block = array_shift( $this->blocks );
        //${$block} = ob_get_clean();
        $this->template->assign( ${$block}, ob_get_contents() );

        ob_get_clean();
    }

    protected function addBlock($name)
    {
        array_unshift( $this->blocks, $name );
        ob_start();
    }


} 