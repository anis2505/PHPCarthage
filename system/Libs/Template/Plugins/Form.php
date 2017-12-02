<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/10/15
 * Time: 4:34 PM
 */

namespace System\Libs\Template\Plugins;

use System\Libs\Template\PluginInterface;

class Form implements PluginInterface
{

    protected  $template; // must be public

    public $formName;

    public $form;
    
    public function __construct()
    {
        
    }

    public function init(&$template)
    {
        $this->template = $template;
        
        $template->register('form_open', $this, 'open');
        $template->register('form_show', $this, 'show');
        $template->register('form_label', $this, 'label');
        $template->register('form_show_all', $this, 'showAll');
        $template->register('form_close', $this, 'close');

        // Register functions
    }

    public function open($form, $class='')
    {
        $this->form = $form;

        return $this->form->open($class);

    }

    public function show($field, $class='')
    {
        return $this->form->show( $field, $class );
    }

    public function label($field, $class='')
    {
        return $this->form->show_label( $field, $class );
    }

    public function showAll($class='', $showLabels=true, $labelsClass='')
    {
        return $this->form->show_all($class, $showLabels, $labelsClass);
    }

    public function close()
    {
        return $this->form->close();
    }


} 