<?php
namespace App\Forms;

use System\Libs\Form\Form;

class UserForm extends Form
{
    
    protected function setup()
    {
        $this->add('first_name',
                   'text',
                   array(
                         'label' => 'First name'
                         )
            )
            ->add('last_name',
                   'text',
                   array(
                         'label' => 'Last name'
                         )
            )
            ->add('dob',
                   'date',
                   array(
                         'label' => 'Date of birth'
                         )
            )
             ->add('submit',
                   'submit',
                   array(
                         'attributes'=>array('value'=>'Envoyer')
                         )
            );
    }
    
    protected function validationRules()
    {
        $this->validations = array(
            'first_name' => 'anything',
            'last_name' => 'anything',
            'dob' => 'date');
        $this->required = array('first_name', 'last_name');
        $this->sanatize = array('first_name');
    }
}