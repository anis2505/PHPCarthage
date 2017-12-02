<?php
namespace System\Libs\Form\Security;

/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/3/15
 * Time: 2:40 PM
 */



use System\Libs\Security\Token;
use System\DIContainer;
use System\Loader;


/**
 * Class CSRF
 *
 * Generates CSRF Tokens used by Form.
 * System\Libs\Form\Security
 */
class CSRF
{

    private static $config = array();

    /**
     * Generates CSRF Security token.
     * Store token in session.
     *
     * @param $name
     * @param $multiple
     */
    public static function get($name, $multiple = false)
    {
        self::init();

        $token = Token::generate($name.static::$config['salt']);
        
        $session = DIContainer::getInstance()->get('Session');// Session::getInstance();
        $session->set($name, ['value' => $token, 'generating_time'  => time(), 'multiple'=>$multiple]);
        
        return $token;

    }

    /**
     * Retrieve Token value from session.
     * The retrieved token will be deleted from session if multiple was set to false
     *
     * @param $name
     * @param $tokenValue
     * @return bool
     */
    public static function check($name, $tokenValue)
    {
        self::init();
        $session = DIContainer::getInstance()->get('Session');

        $csrf = $session->get($name);
        
        if($csrf === null)
            return false;
        
        if(! $csrf['multiple'])
            $session->remove($name);

        $tokenLifetime = time() - $csrf['generating_time'];// + self::$config['lifetime'];

        return ($tokenLifetime <= self::$config['lifetime'] && $csrf['value'] === $tokenValue);

    }

    private static function init()
    {
        static::$config = Loader::$configs['configs']['form']['csrf'];
    }

} 