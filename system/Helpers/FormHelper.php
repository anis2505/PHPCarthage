<?php
namespace System\Helpers;


class FormHelper
{
    
    public static $separator ="<br/>";
    
    public static function formOpen($name, $action, $method='post', $attributes = array())
    {
        $attributes_string = (!empty($attributes))?self::getAttributes($attributes) : "";
        return "<form name='{$name}' action='{$action}' method='{$method}' {$attributes_string}>".self::$separator;
    }
    
    public static function formClose()
    {
        return "</form>";
    }
    
    public static function getFormField($fieldName, $fieldType, $options)
    {
        //$type = $fieldType;
        return self::{$fieldType}($fieldName, $fieldType, $options).self::$separator;
    }
    
    private static function text($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function number($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function password($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }

    private static function hidden($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function input($fieldName, $fieldType, $options)
    {
        $attributes = (isset($options['attributes']))?self::getAttributes($options['attributes']) : '';
        $value = (isset($options['value']))?$options['value'] : '';
        return "<input type='{$fieldType}' name='{$fieldName}' {$attributes} value='{$value}'/>";
    }
    
    private static function textarea($fieldName, $fieldType, $options)
    {
        $value = (isset($options['value']))?$options['value'] : '';
        $attributes = (isset($options['attributes']))?self::getAttributes($options['attributes']) : '';
        return "<textarea name='{$fieldName}' {$attributes}>{$value}</textarea>";
    }
    
    private static function checkbox($fieldName, $fieldType, $options)
    {
        $attributes = (isset($options['attributes']))?self::getAttributes($options['attributes']) : '';
        $text  = (isset($options['text']))?$options['text'] : '';
        $checked = (isset($options['value']))?'checked':'';
        return "<input type='checkbox' name='{$fieldName}' {$attributes} {$checked} /> {$text}";
    }
    
    private static function radio($fieldName, $fieldType, $options)
    {
        $html = "";
        $attributes = (isset($options['attributes']))?self::getAttributes($options['attributes']) : '';
        foreach($options['values'] as $option)
        {
            $valValue = $option['value'];
            $valText  = (isset($option['text']))?$option['text'] : '';
            $checked = (isset($options['value']) && $options['value']==$valValue)?'checked':'';
            $html.="<input type='radio' name='{$fieldName}' value='{$valValue}' {$attributes} {$checked}> {$valText}";
        }
        return $html;
    }
    
    private static function select($fieldName, $fieldType, $options)
    {
        $attributes = (isset($options['attributes']))?self::getAttributes($options['attributes']) : '';
        $html = "<select name='{$fieldName}' {$attributes}>";
        foreach($options['values'] as $option)
        {
            $valValue = $option['value'];
            $valText  = (isset($option['text']))?$option['text'] : '';
            $selected = (isset($options['value']) && $options['value']===$valValue)?'selected':'';
            $html.="<option value='{$valValue}' {$selected}>{$valText}</option>";
        }
        $html.="</select>";
        return $html;
    }
    
    private static function file($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function submit($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function reset($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function button($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function date($fieldName, $fieldType, $options)
    {
        return self::input($fieldName, $fieldType, $options);
    }
    
    private static function getAttributes($attributes)
    {
        $attributes_string = '';
        foreach($attributes as $key=>$value)
        {
            $attributes_string.=' '.$key."='".$value."'";
        }
        return $attributes_string;
    }
    
    public static function getLabel($field, $label, $class='')
    {
        return "<label for='$field' class='$class'>$label</label>".self::$separator;
    }
    
}
