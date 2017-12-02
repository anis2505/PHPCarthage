<?php
namespace System\Helpers;


class ObjectHelper
{
    public static function getObjectAsArray($object)
    {
        $data = array();
        if(! is_object($object))
            return $data;
        
        $keys = array_keys(get_object_vars($object));
		
		foreach($keys as $key)
		{
            $data[$key] = $object->{$key};
		}
        
        return $data;
    }
}