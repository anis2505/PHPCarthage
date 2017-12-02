<?php
namespace System\Libs\UserManager\Forms;

use System\Libs\Form\Form;

class LoginForm extends Form
{
    
    protected function setup()

    {
        $this->name = 'login';

        $this->add('username',
                   'text',
                   array(
                       'label' =>'Username',
                       'attributes'=>array('required' => 'required')
                   )
            )
            ->add('password',
                'password',
                array(
                    'label' => 'Password',
                    'attributes'=>array('required' => 'required')
                )
            )
             ->add('rememberme',
                   'checkbox',
                   array('text'=>'Remember me','attributes'=>array('value'=>'1'))
            )
             ->add('submit',
                   'submit',
                   array('value'=>'Login')
            );

    }

    protected function validationRules()
    {
        $this->validations = array(
            'username' => array('required'=>true),
            'password' => array('required'=>true)
        );
        $this->sanitize = array(
            'username' => array('string'),
            'password' => array('string')
        );
    }
}