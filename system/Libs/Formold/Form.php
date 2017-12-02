<?php
namespace System\Libs\Form;

use System\Helpers\HtmlFormHelper as FormHelper;

class Form
{
    
    protected $fields       = array();
    protected $name         = 'form';
    protected $action       = '';
    protected $method       = 'post';
    protected $attributes   = array();
    protected $validations  = array();
    protected $sanatize     = array();
    protected $required     = array();
    protected $data         = array();
    protected $validator;
    
    
    public function __construct($data = array())
    {
        $this->data = $data;
        $this->setup();
        $this->validationRules();
        $this->validator = new FormValidator($this->validations, $this->required, $this->sanatize);
    }
    
    protected function setup(){}
    
    protected function validationRules(){}
    
    /**
     *
     *  @param String fieldName The fieldName
     *  @param String fieldType the Htmkl field type such text, checkbox, etc
     *  @param Array options the field options the format: option( 'attributes'=>array(),values, etc)
     */
    
    public function add($fieldName, $fieldType, $options = array())
    {
        $this->fields[$fieldName] = array($fieldType, $options);
        return $this;   
    }
    
    public function open()
    {
        echo FormHelper::formOpen($this->name, $this->action, $this->method, $this->attributes);
    }
    
    public function close()
    {
        echo FormHelper::formClose();
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
        $name       = $this->name.'['.$fieldName.']';
        $fieldType  = $this->fields[$fieldName][0];
        $options    = $this->fields[$fieldName][1];
        if($class!=='')
            $options['attributes']['class'] = $class;
        echo FormHelper::getFormField($name, $fieldType, $options);
    }
    
    public function show_label($fieldName, $class='')
    {
        if(isset($this->fields[$fieldName][1]['label']))
            echo FormHelper::getLabel($fieldName, $this->fields[$fieldName][1]['label'], $class);
        
    }
    
    public function show_all($showLabeles=false)
    {
        foreach($this->fields as $key=>$value)
        {
            if($showLabeles);
                $this->show_label($key);
            $this->show($key);
        }
    }
    
    public function validate()
    {
        if($this->validator->validate($this->data))
        {
            $this->haveErrors = false;
        }
        else
        {
            $this->haveErrors = true;
        }
        return !$this->haveErrors;
    }
    
    public function has_errors($field)
    {
        if(isset($this->haveErrors) && $this->haveErrors===true && array_key_exists($field,$this->validator->errors))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function getErrorFields()
    {
        return $this->validator->errors;
    }
}