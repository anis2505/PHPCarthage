<?php
namespace System\Libs\Cookie;
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/3/15
 * Time: 8:09 PM
 */


/**
 * Class Cookie
 * @package System\Libs\Cookie
 *
 * Simple cookies manager
 *
 */
class Cookie
{
    /**
     * Create Cookie.
     *
     * Create cookie.
     * It's a simple wrapper to PHP's "setcookie" function.
     *
     * @param $name
     * @param $value
     * @param $lifetime
     * @param string $path
     * @param string $domain
     * @param int $isSecured
     * @param int $httpOnly
     *
     *
     */
    public static function create($name, $value, $lifetime, $path='/', $domain='', $isSecured=false, $httpOnly=false)
    {
        if(self::areCookiesEnabled())
            return setcookie($name, $value, time()+$lifetime, $path, $domain, $isSecured, $httpOnly);
        return false;
    }

    /**
     * Get cookie value.
     * if cookie was not found a null value is returned.
     *
     * @param $name
     * @return null
     */
    public static function get($name)
    {
        if(self::areCookiesEnabled())
            if(isset($_COOKIE[$name]))
                return $_COOKIE[$name];
        return null;
    }

    /**
     * Removes a cookie identified by it's name.
     *
     * @param $name
     */
    public static function remove($name)
    {
        if(self::areCookiesEnabled() && isset($_COOKIE[$name]))
        {
            unset($_COOKIE[$name]);
            return setcookie($name, "", time() - 3600);
        }
    }

    /**
     * Checks whether cookies are enabled or not
     *
     * @return bool
     */
    public static function areCookiesEnabled()
    {
        return (count($_COOKIE)>0);
    }


}
