<?php
namespace App\Forms;

use System\Libs\Form\Form;
use System\Libs\Form\Callabale;

class SampleForm extends Form
{
    
    protected function setup()
    
    {
        $this->add('textsample',
            'text',
            array('label'=>'Sample text', 'attributes'=>array('class'=>'form-control'))
            )
            ->add('ssn',
                'text',
                array('label'=>'SSN', 'attributes'=>array('class'=>'form-control'))
                )
                ->add('textsample_again',
                    'text',
                    array('label'=>'Another sample text', 'attributes'=>array('class'=>'form-control'))
                    )
                    ->add('textareasample',
                        'textarea',
                        array('label'=>'A sample text area', 'text'=>'A text area')
                        )
                        ->add('checkboxsample',
                            'checkbox',
                            array('label'=>'Sample checkbox', 'text'=>'CheckBoxSample','attributes'=>array('value'=>'1'))
                            )
                            ->add('radiosample',
                                'radio',
                                array('label'=>'Radio sample', 'values'=>array(
                                    array('text'=>'Male','value'=>'1','checked'=>true),
                                    array('text'=>'Female','value'=>'2')
                                )
                                )
                                )
                                ->add('selectsample',
                                    'select',
                                    array('label'=>'Select sample', 'values'=>array(
                                        array('text'=>'Choisir un moteur de recherche','value'=>'', 'selected'=>true),
                                        array('text'=>'Google','value'=>'google'),
                                        array('text'=>'Bing','value'=>'bing'),
                                        array('text'=>'AltaVista','value'=>'altavista')
                                    ),
                                        'attributes'=>array('size'=>5)
                                    )
                                    )
                                    ->add('numbersample',
                                        'number',array('label'=>'Sample number field')
                                        )
                                        ->add('datesample',
                                            'date', array('label'=>'Sample date field')
                                            )
                                            ->add('submitsample',
                                                'submit',
                                                array('value'=>'envoyer')
                                                );
    }
    
    protected function validationRules()
    {
        $this->validations = array(
            'textsample'            => array('required'=>true,'min'=>3,'max'=>20),
            //'matricule'             =>array('unique'=>'users','max'=>20),
            'textsample_again'        =>array('matches'=>'textsample'),
            'textareasample'        =>array('required'=>true,'regex'=>'username'),
            'numbersample'          =>array('regex'=>'int'),
            'selectsample'          =>array('custom'=> function($data)
            {
                if(!array_key_exists('selectsample',$data) OR $data['selectsample']!='bing')
                    return array(false,'Select must be Bing');
                    return array(true);
            }),
            'radiosample'=>array('required'=>true)
            );
        $this->sanitize = array(
            'textsample'=>array('string'),
            /*'numbersample'=>array(function($value){
            return $value*10;
            })*/
            );
    }
}