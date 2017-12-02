<?php
namespace System\Libs\Cache;

interface CacheInterface
{   
    public function get($key);
    public function set($key, $value);
    public function remove($key);
}