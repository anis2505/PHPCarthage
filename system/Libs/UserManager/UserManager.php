<?php
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/8/15
 * Time: 6:31 PM
 */

namespace System\Libs\UserManager;

use System\DIContainer;

use System\Libs\Cookie\Cookie;
use System\Libs\Security\Token;
use System\Libs\Session\Session;
use System\Loader;

class UserManager
{
    protected  static $config;

    public static $entityClass;

    protected $entity = null;
    
    protected $container;

    
    public function __construct()
    {
        $this->container = DIContainer::getInstance();
        
        static::$config = Loader::$configs['configs']['user'];
        
        static::$entityClass = static::$config['entity'];

        $this->entity = new static::$entityClass();

        $this->loadUser();
        $this->storeUserInSession();
    }

    public function loadUser( )
    {
        return ($this->loadUserFromSession() OR $this->loadUserFromCookie());
    }

    protected function loadUserFromSession()
    {
        $session = $this->container->get('Session');

        $user = $session->get(static::$config['session_variable']);

        if(! $user or $user['status'] == 'anonymous')
            return false;

        $this->entity->setData($user['data']);

        return true;
    }

    protected function loadUserFromCookie()
    {
        $value = $this->getCookieValue();

        if( ! $value )
            return false;
        
        $this->entity = new static::$entityClass();
            
        $user = $this->entity->getUser(array(), array('token='=>$value));

        if(! $user)
            return false;

        $this->entity->setData($user);
        
        return $this->rememberUser(true);
    }

    protected  function storeUserInSession()
    {
        $data = array('status' => 'anonymous');

        $entityData = $this->entity->getData();
        
        if(! empty($entityData))
        {
            $data['status'] = 'loggedin';
            $data['data']   = $entityData;
        }

        $session = $this->container->get('Session');

        $session->set(static::$config['session_variable'], $data);
    }

    public function checkUser( $username, $password )
    {
        
        $user = $this->entity->getUser(array('id, username','password'), array('username='=>$username));
        
        if(! $user)
            return false;
        
        return $this->verifyPassword($password, $user['password']);
    }

    public function registerUser($data = array())
    {
        if( array_key_exists( 'password', $data ) )
            $data['password'] = $this->hashPassword( $data['password'] );

        return $this->entity->createUser( $data );
    }

    public function updateUser($data, $conditions)
    {
        if( array_key_exists('password', $data))
            $data['password'] = $this->hashPassword( $data['password'] );

        return $this->entity->updateUser( $data, $conditions );
    }

    public function deleteUser( $conditions )
    {
        return $this->entity->deleteUser( $conditions );
    }

    public function logUserIn( $data = array() )
    {
        /*
        $params = array(
            'username='=>$data['username'],
            'password='=>$this->hashPassword($data['password'])
        );
        */
        if(! $this->checkUser($data['username'],$data['password']))
            return false;

        $this->entity = $this->entity->getLastFetched();

        $this->storeUserInSession();
        
        if(isset($data['rememberme']))
            return $this->rememberUser(true);
        
        return true;
    }

    public function logUserOut()
    {
        $this->rememberUser(false);

        $this->entity = new static::$entityClass();

        $this->storeUserInSession();

    }

    public function rememberUser($status = false)
    {
        $cookieName = static::$config['cookie_name'];
        $value = Cookie::get( $cookieName );

        if( $status )
            return $this->setRememberMe( $cookieName, $value );

        return $this->removeRememberMe( $cookieName, $value );

    }

    protected function removeRememberMe( $cookieName, $value )
    {

        if( $value && $value == $this->entity->token )
        {
            Cookie::remove( $cookieName );

            $this->entity->token = '';
            $this->entity->updateUser( array( 'token' => '' ), array( 'id='=>$this->entity->id ) );
        }
        return true;
    }

    protected function setRememberMe($cookieName, $value)
    {
        if( $value && $value == $this->entity->token )
            Cookie::remove( $cookieName );

        $tokenName = $this->entity->id.$this->entity->username;

        $token = Token::generate( $tokenName, static::$config['salt'] );

        $this->entity->token = $token;
        $this->entity->updateUser(array( 'token' => $token ), array( 'id='=>$this->entity->id ) );

        return Cookie::create( $cookieName, $token, static::$config['cookie_lifetime'] );
    }

    protected function hashPassword($password)
    {
        return password_hash($password,static::$config['hash_algorithm']);
    }
    
    protected function verifyPassword($candidatePassword, $hashedPassword)
    {
        return password_verify($candidatePassword, $hashedPassword);
    }


    protected function getCookieValue()
    {
        $cookieName = static::$config['cookie_name'];
        return Cookie::get( $cookieName );
    }

    protected function init()
    {

    }

} 