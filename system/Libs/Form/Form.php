<?php
namespace System\Libs\Form;

use System\Helpers\FormHelper;
use System\Libs\Form\Security\CSRF;

class Form
{
    
    protected $fields       = [];
    protected $shownFields  = [];
    protected $name         = 'form';
    protected $action       = '';
    protected $method       = 'POST';
    protected $attributes   = [];
    protected $validations  = [];
    protected $sanitize     = [];
    protected $required     = [];
    protected $errors       = [];
    protected $hasErrors    = false;
    protected $data         = [];
    protected $csrfField    = '_csrf_';
    protected $validator;

    
    public function __construct($data = [], $name='form', $method='POST')
    {
        $this->data = $data;
        $this->name = $name;
        $this->method = $method;
        $this->setup();
        $this->validationRules();
        $this->validator = new Validation();
    }

    protected function addCSRFField()
    {
        $token = CSRF::get($this->name.$this->csrfField);
        $this->add($this->csrfField, 'hidden', ['value'=>$token]);
        $this->data[$this->csrfField] = $token;
    }
    
    protected function setup(){}
    
    protected function validationRules(){}
    
    /**
     *
     *  @param String fieldName The fieldName
     *  @param String fieldType the Htmkl field type such text, checkbox, etc
     *  @param Array options the field options the format: option( 'attributes'=>[],values, etc)
     */
    
    public function add($fieldName, $fieldType, $options = [])
    {
        $this->fields[$fieldName] = [$fieldType, $options];
        return $this;   
    }
    
    public function open($class='')
    {

        $this->addCSRFField();
        if($class!='')
            $this->attributes['class'] = $class;
        echo FormHelper::formOpen($this->name, $this->action, $this->method, $this->attributes);
    }
    
    public function close()
    {
        if( array_key_exists( $this->csrfField, $this->fields )
            && ! array_key_exists( $this->csrfField, $this->shownFields ) )
        {
            $this->show( $this->csrfField );
        }

        echo FormHelper::formClose();
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
    
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData( $field ='', $sanitized=false )
    {
        if( $field && array_key_exists($field, $this->data))
            return (!$sanitized)?$this->data[$field]:$this->validator->getData()[$field];

        return (!$sanitized)?$this->data:$this->validator->getData();
    }
    
    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }
    
    public function removeAttribute($attribute)
    {
        unset($this->attributes[$attribute]);
        return $this;
    }
    
    public function show($fieldName, $class='')
    {
        if(array_key_exists($fieldName, $this->shownFields))
            return;//echo '<br/>Already shown<br/>';

        array_push($this->shownFields, $fieldName);

        $name       = $this->name.'['.$fieldName.']';
        $fieldType  = $this->fields[$fieldName][0];
        $options    = $this->fields[$fieldName][1];

        if( $class !== '' )
            $options['attributes']['class'] = $class;

        $options = array_merge($options, $this->BindData($fieldName));

        echo FormHelper::getFormField($name, $fieldType, $options);
        //$this->shownFields[] = $fieldName;
    }

    protected function BindData($fieldName)
    {
        if(!empty($this->data) && array_key_exists($fieldName, $this->data))
        {
            return ['value'=>$this->data[$fieldName]];
        }
        return [];
    }
    
    public function show_label($fieldName, $class='')
    {
        if(isset($this->fields[$fieldName][1]['label']))
            echo FormHelper::getLabel($fieldName, $this->fields[$fieldName][1]['label'], $class);
        
    }
    
    public function show_all($class='', $showLabels=false, $labelsClass='')
    {
        $remainigFields = array_diff( array_keys( $this->fields ), $this->shownFields );

        foreach( $remainigFields as $field )
        {
            if($field == $this->csrfField)
                continue;
            
            if($showLabels);
                $this->show_label( $field, $labelsClass );

            $this->show( $field, $class );
        }
    }
    
    public function validate($checkCSRF=true)
    {
        /*
        if($checkCSRF && !CSRF::check($this->name.$this->csrfField, $this->data[$this->csrfField]))
        {
            $this->hasErrors = true;
            $this->addErrors($this->csrfField, 'Your session has expired');
        }
        else
        {
            $this->haveErrors = !$this->validator->validate($this->data, $this->validations, $this->sanitize);
            return !$this->validator->hasErrors();
        }
        */
        //$this->hasErrors = false;
        
        $this->hasErrors = !$this->validator->validate($this->data, $this->validations, $this->sanitize);
        if($checkCSRF && !CSRF::check($this->name.$this->csrfField, $this->data[$this->csrfField]))
        {
            echo "<br/>CSRF Field: ".$this->data[$this->csrfField].'<br/>';
            $this->hasErrors = true;
            $this->addErrors($this->csrfField, 'Your session has expired');
        }
        
        return ! $this->hasErrors;
        
    }

    protected function addErrors($field, $error)
    {
        if(!isset($this->errors[$field]))
            $this->errors[$field] = [];
        $this->errors[$field][] = $error;
    }
    
    public function has_errors($field)
    {
        return (array_key_exists($field, $this->errors) OR $this->validator->hasErrors($field));
    }
    
    public function getErrorFields()
    {
        return array_merge($this->errors, $this->validator->getErrors());
    }
}