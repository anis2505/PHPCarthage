<?php
namespace System;


class Controller
{
    
    
	protected $template;
	
	protected $container;

	public function __construct($container)
	{
	    $this->container = $container;
	    $this->template = $this->container->get('Template');
	    
	}



}