<?php
    $this->form->setAction($this->hardroute('home','login'));
	$this->form->open();
    $this->form->show_all('',true);
    /*
	$form->show_label('first_name');
	$form->show('first_name');
	$form->show_label('last_name');
	$form->show('last_name');
	$form->show_label('dob');
	$form->show('dob');
	$form->show('submit');
	//$form->showAll();
	*/
	$this->form->close();