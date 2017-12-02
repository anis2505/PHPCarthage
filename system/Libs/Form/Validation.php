<?php
namespace System\Libs\Form;
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/1/15
 * Time: 9:36 PM
 */



use System\Model;


/**
 * Class Validation
 * Darwin\kage Sys\Libs\Form
 *
 * Validates data using
 * - PreBuid function : returns true if success or false if not
 * - Custom function using anonymous functions: returns array($successORfalure, $errorMessage)
 */
class Validation
{

    private $errors = array();
    private static $db = null;
    private $item;  // currently checked item
    private $has_errors = false;
    private $data = array();
    private $sanitizedItems = array();
    private static $regexes = array(

        'date' => "^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2}\$",
        'amount' => "^[-]?[0-9]+\$",
        'number' => "^[-]?[0-9,]+\$",
        'alfanum' => "^[0-9a-zA-Z ,.-_\\s\?\!]+\$",
        'not_empty' => "[a-z0-9A-Z]+",
        'words' => "^[A-Za-z]+[A-Za-z \\s]*\$",
        'phone' => "^[0-9]{10,11}\$",
        'zipcode' => "^[1-9][0-9]{3}[a-zA-Z]{2}\$",
        'plate' => "^([0-9a-zA-Z]{2}[-]){2}[0-9a-zA-Z]{2}\$",
        'price' => "^[0-9.,]*(([.,][-])|([.,][0-9]{2}))?\$",
        '2digitopt' => "^\d+(\,\d{2})?\$",
        '2digitforce' => "^\d+\,\d\d\$",
        'anything' => "^[\d\D]{1,}\$",
        'username' => "^[\w]{3,32}\$"

    );
    /**
     * @var string
     * Contains the temporary regex parameters
     * Used by fitler_var;
     */
    private $regexParams = array();
    /**
     * @var string
     * Contains the temporary sanitize parameters
     * Used by fitler_var with FILTER_CALLBACK
     */
    private $sanitizeParams = array();

    public function __construct()
    {
        
    }

    public function validate($data, $items, $sanitizedItems=array())
    {
        $this->init($data, $sanitizedItems);
        $this->sanitize();
        foreach($items as $item => $rules)
        {
            $this->item = $item;
            foreach($rules as $rule=>$value)
            {  /*
               if($rule === 'custom' && $this->isACallback($value))
               {
                   
                   
                   $params = array($data);
                   if(!$this->runCallback($value,$params))
                       $this->has_errors = true;
               }
               */
               if($rule === 'custom' && is_callable($value))// instanceof Callabale)// $this->isACallback($value))
               {
                   $params = array($data);
                   $result = call_user_func_array($value, $params);
                   if(($this->has_errors = ! $result[0]) == false)
                        $this->addError($this->item,$result[1]);
               }
               else if(method_exists($this,$rule))
               {
                   if(!$this->runOwnMethod($rule,$value))
                       $this->has_errors = true;
               }
            }
        }
        return !$this->has_errors;
    }

    public function hasErrors($field=null)
    {
        if(null == $field)
            return $this->has_errors;
        else
            return array_key_exists($field,$this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getData()
    {
        return $this->data;
    }

    private function sanitize()
    {
        foreach($this->sanitizedItems as $item=>$filter)
        {
            if(!array_key_exists($item, $this->data))
                continue;

            foreach($filter as $filterItem)
            {
                $filterCallback = $this->getSanitizeFilter($filterItem);
                if($filterCallback === false)
                    continue;

                $this->data[$item] = filter_var($this->data[$item], $filterCallback, $this->sanitizeParams);
            }
        }
    }

    private function init($data, $sanitizedItems)
    {
        $this->data = $data;
        $this->sanitizedItems = $sanitizedItems;
        $this->errors = array();
        $this->has_errors = false;
    }

    private function isACallback($rule)
    {
        if(is_callable($rule) && $rule instanceof \Closure)
            return true;
        return false;
    }

    private function runCallback($callback, $params)
    {
        $parameters = (is_array($params))?$params:array($params);
        $result = call_user_func_array($callback, $parameters);
        if(isset($result[1]))
            $this->addError($this->item,$result[1]);
        return $result[0];
    }

    private function runOwnMethod($method, $params)
    {
        $parameters = (is_array($params))?$params:array($params);
        return call_user_func_array(array($this, $method), $parameters);
    }

    private function required()
    {
        $value = $this->getCurrentItemValue();
        if(!array_key_exists($this->item, $this->data) OR empty($value))
        {
            $this->addError($this->item, $this->item." is required.");
            return false;
        }
        return true;
    }

    private function min($value)
    {
        if(!array_key_exists($this->item, $this->data) OR strlen($this->getCurrentItemValue()) < $value)
        {
            $this->addError($this->item, $this->item." must be minumum of {$value} characters.");
            return false;
        }
        return true;
    }

    private function max($value)
    {

        if(!array_key_exists($this->item, $this->data) OR strlen($this->getCurrentItemValue()) > $value)
        {
            $this->addError($this->item, $this->item." must be maximum of {$value} characters.");
            return false;
        }
        return true;
    }

    private function unique($table)
    {
        
        $query = 'SELECT '.$this->item.' from '.$table.' WHERE '.$this->item.'=?';
        
        $value = $this->getCurrentItemValue();
        $resultSet = Model::find_by_sql($query, array($value));
        
        if(count($resultSet)>0)
        {
            $this->addError($this->item, $this->item.': '.$this->getCurrentItemValue().' already exists.');
            return false;
        }
        
        return true;
    }

    private function matches($field)
    {
        if(!array_key_exists($this->item, $this->data) OR $this->getCurrentItemValue()!==$this->getItemValue($field))
        {
            $this->addError($this->item, $this->item." must match {$field}.");
            return false;
        }
        return true;
    }

    private function addError($field, $error)
    {
        if(!array_key_exists($field, $this->errors))
            $this->errors[$field] = array();
        $this->errors[$field][] = $error;
    }

    private function getItemValue($item)
    {
        return (array_key_exists($item,$this->data))?$this->data[$item]:null;
    }

    private function getCurrentItemValue()
    {
        return $this->getItemValue($this->item);
    }

    private function regex($filter)
    {
        $filterCallback = $this->getRegextFilter($filter);
        if($filterCallback === false)
            return true;

        if(!array_key_exists($this->item, $this->data) OR !filter_var($this->getCurrentItemValue(), $filterCallback, $this->regexParams))
        {
            $this->addError($this->item, $this->getCurrentItemValue()." is not a valid {$filter}.");
            return false;
        }
        return true;
    }

    private function getRegextFilter($filter)
    {
        $filterCallBack = false;
        if( array_key_exists($filter, static::$regexes))
        {
            $filterCallBack = FILTER_VALIDATE_REGEXP;
            $this->regexParams = array("options"=> array("regexp"=>'!'.self::$regexes[$filter].'!i'));
        }
        else
            switch($filter)
            {
                case 'email':
                    $filterCallBack = FILTER_VALIDATE_EMAIL;
                    break;
                case 'int':
                    $filterCallBack = FILTER_VALIDATE_INT;
                    break;
                case 'float':
                    $filterCallBack = FILTER_VALIDATE_FLOAT;
                    break;
                case 'boolean':
                    $filterCallBack = FILTER_VALIDATE_BOOLEAN;
                    break;
                case 'ip':
                    $filterCallBack = FILTER_VALIDATE_IP;
                    break;
                case 'url':
                    $filterCallBack = FILTER_VALIDATE_URL;
                    break;
                case 'mac':// PHP 5.5
                    $filterCallBack = FILTER_VALIDATE_MAC;
                    break;
            }
        return $filterCallBack;
    }

    private function getSanitizeFilter($filter)
    {
        $filterCallBack = false;
        if($this->isACallback($filter))
        {
            $filterCallBack = FILTER_CALLBACK;
            $this->sanitizeParams = array("options"=> $filter);
        }
        else
            switch($filter)
            {
                case 'string':
                    $filterCallBack = FILTER_SANITIZE_STRING;
                    break;
                case 'magic_quotes':
                    $filterCallBack = FILTER_SANITIZE_MAGIC_QUOTES;
                    break;
                case 'special_chars':
                    $filterCallBack = FILTER_SANITIZE_SPECIAL_CHARS;
                    break;
                case 'email':
                    $filterCallBack = FILTER_SANITIZE_EMAIL;
                    break;
                case 'float':
                    $filterCallBack = FILTER_SANITIZE_NUMBER_FLOAT;
                    break;
                case 'int':
                    $filterCallBack = FILTER_SANITIZE_NUMBER_INT;
                    break;
                case 'url':
                    $filterCallBack = FILTER_SANITIZE_URL;
                    break;
                case 'stripped':
                    $filterCallBack = FILTER_SANITIZE_STRIPPED;
                    break;
                case 'encoded':
                    $filterCallBack = FILTER_SANITIZE_ENCODED;
                    break;
            }
        return $filterCallBack;
    }

} 