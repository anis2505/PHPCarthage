<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/2/15
 * Time: 10:57 PM
 *
 * Generates Security tokens.
 * Store tokens in session.
 * Retrieve security token from session.
 *
 */

namespace System\Libs\Security;


use System\DIContainer;

class Token
{

    /**
     * Generates Security token.
     * Store token in session.
     *
     * @param $tokenName
     * @param string $salt
     * @return string
     */
    public static function generate($tokenName, $salt='')
    {
        $session = DIContainer::getInstance()->get('Session');

        $token =  md5(uniqid($salt));
        $session->{$tokenName} = $token;

        return $token;
    }



} 