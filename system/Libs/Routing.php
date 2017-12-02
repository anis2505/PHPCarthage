<?php
/**
 * Based on AltoRouter library
 * Just localization support and auto_routing added
 */
namespace System\Libs;


use System\Exceptions\RoutingException;

class Routing
{
    
    protected $routes = array();
    protected $namedRoutes = array();
    protected $basePath = '';
    protected $matchTypes = array(
        'i'  => '[0-9]++',
        'a'  => '[0-9A-Za-z]++',
        'h'  => '[0-9A-Fa-f]++',
        '*'  => '.+?',
        '**' => '.++',
        ''   => '[^/\.]++'
    );
    
    protected $isHardRoutingEnabled = false;
    
    protected $isLocaleEnabled = false;
    protected $locales = array();
    protected $locale = null;
    
    /**
     * Create router in one call from config.
     *
     * @param array $routes
     * @param string $basePath
     * @param array $matchTypes
     */
    public function __construct( $routes = array(), $basePath = '', $matchTypes = array() ) {
        $this->addRoutes($routes);
        $this->setBasePath($basePath);
        $this->addMatchTypes($matchTypes);
        
    }
    
    public function setLocalization($isEnabled = false, $locales = array())
    {
       $this->isLocaleEnabled = $isEnabled;
       $this->locales = $locales;
    }
    
    public function setHardRouting($isHardRoutingEnabled = false)
    {
        $this->isHardRoutingEnabled = $isHardRoutingEnabled;
    }
    
    /**
     * Add multiple routes at once from array in the following format:
     *
     *   $routes = array(
     *      array($method, $route, $target, $name)
     *   );
     *
     * @param array $routes
     * @return void
     * @author Koen Punt
     */
    public function addRoutes($routes){
        if(!is_array($routes) && !$routes instanceof \Traversable) {
            throw new RoutingException('Routes should be an array or an instance of Traversable');
        }
        foreach($routes as $route) {
            call_user_func_array(array($this, 'map'), $route);
        }
    }
    
    /**
     * Set the base path.
     * Useful if you are running your application from a subdirectory.
     */
    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }
    
    /**
     * Add named match types. It uses array_merge so keys can be overwritten.
     *
     * @param array $matchTypes The key is the name and the value is the regex.
     */
    public function addMatchTypes($matchTypes) {
        $this->matchTypes = array_merge($this->matchTypes, $matchTypes);
    }
    
    /**
     * Map a route to a target
     *
     * @param string $method One of 4 HTTP Methods, or a pipe-separated list of multiple HTTP Methods (GET|POST|PUT|DELETE)
     * @param string $route The route regex, custom regex must start with an @. You can use multiple pre-set regex filters, like [i:id]
     * @param mixed $target The target where this route should point to. Can be anything.
     * @param string $name Optional name of this route. Supply if you want to reverse route this url in your application.
     */
    public function map($method, $route, $target, $name = null) {
        
        $this->routes[] = array($method, $route, $target, $name);
        
        if($name) {
            if(isset($this->namedRoutes[$name])) {
                throw new RoutingException("Can not redeclare route '{$name}'");
            } else {
                $this->namedRoutes[$name] = $route;
            }
            
        }
        
        return;
    }
    
    /**
     * Reversed routing
     *
     * Generate the URL for a named route. Replace regexes with supplied parameters
     *
     * @param string $routeName The name of the route.
     * @param array @params Associative array of parameters to replace placeholders with.
     * @return string The URL of the route with named parameters in place.
     */
    public function generate($routeName, array $params = array()) {
        
        // Check if named route exists
        if(!isset($this->namedRoutes[$routeName])) {
            throw new RoutingException("Route '{$routeName}' does not exist.");
        }
        
        // Replace named parameters
        $route = $this->namedRoutes[$routeName];
        
        // prepend base path to route url again
        //$url = $this->basePath . $route;
        $url = (null != $this->locale)?$this->basePath . '/' . $this->locale.$route: $this->basePath . $route;
        
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            
            foreach($matches as $match) {
                list($block, $pre, $type, $param, $optional) = $match;
                
                if ($pre) {
                    $block = substr($block, 1);
                }
                
                if(isset($params[$param])) {
                    $url = str_replace($block, $params[$param], $url);
                } elseif ($optional) {
                    $url = str_replace($pre . $block, '', $url);
                }
            }
            
            
        }
        
        return $url;
    }
    
    /**
     * Match a given Request Url against stored routes
     * @param string $requestUrl
     * @param string $requestMethod
     * @return array|boolean Array with route information on success, false on failure (no match).
     */
    public function match($requestUrl = null, $requestMethod = null) {
        
        $params = array();
        $match = false;
        $locale = null;
        
        // set Request Url if it isn't passed as parameter
        if($requestUrl === null) {
            $requestUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        }
        
        // strip base path from request url
        $requestUrl = substr($requestUrl, strlen($this->basePath));
        
        // Strip query string (?a=b) from Request Url
        if (($strpos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $strpos);
        }
        
        // Strip locale string if enabled from Request Url
        if ($this->isLocaleEnabled && ($strpos = strpos(ltrim($requestUrl,'/'), '/')) !== false) {
            
            $locale = ltrim(substr($requestUrl, 0, $strpos+1),'/');
            
            if(in_array($locale, $this->locales))
            {
                $requestUrl = substr($requestUrl, $strpos+1);
                //if($requestUrl == "")
                 //   $requestUrl = "/";
            }
            else
            {
                $locale = null;
            }
            $this->locale = $locale;
        }
        //echo "<br/>Request URL:".$requestUrl."<br/>";
        // set Request Method if it isn't passed as a parameter
        if($requestMethod === null) {
            $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        }
        
        // Force request_order to be GP
        // http://www.mail-archive.com/internals@lists.php.net/msg33119.html
        $_REQUEST = array_merge($_GET, $_POST);
        
        foreach($this->routes as $handler) {
            list($method, $_route, $target, $name) = $handler;
            
            $methods = explode('|', $method);
            $method_match = false;
            
            // Check if request method matches. If not, abandon early. (CHEAP)
            foreach($methods as $method) {
                if (strcasecmp($requestMethod, $method) === 0) {
                    $method_match = true;
                    break;
                }
            }
            
            // Method did not match, continue to next route.
            if(!$method_match) continue;
            
            // Check for a wildcard (matches all)
            if ($_route === '*') {
                $match = true;
            } elseif (isset($_route[0]) && $_route[0] === '@') {
                $match = preg_match('`' . substr($_route, 1) . '`u', $requestUrl, $params);
            } else {
                $route = null;
                $regex = false;
                $j = 0;
                $n = isset($_route[0]) ? $_route[0] : null;
                $i = 0;
                
                // Find the longest non-regex substring and match it against the URI
                while (true) {
                    if (!isset($_route[$i])) {
                        break;
                    } elseif (false === $regex) {
                        $c = $n;
                        $regex = $c === '[' || $c === '(' || $c === '.';
                        if (false === $regex && false !== isset($_route[$i+1])) {
                            $n = $_route[$i + 1];
                            $regex = $n === '?' || $n === '+' || $n === '*' || $n === '{';
                        }
                        if (false === $regex && $c !== '/' && (!isset($requestUrl[$j]) || $c !== $requestUrl[$j])) {
                            continue 2;
                        }
                        $j++;
                    }
                    $route .= $_route[$i++];
                }
                
                $regex = $this->compileRoute($route);
                $match = preg_match($regex, $requestUrl, $params);
            }
            
            if(($match == true || $match > 0)) {
                
                if($params) {
                    foreach($params as $key => $value) {
                        if(is_numeric($key)) unset($params[$key]);
                    }
                }
                
                return array(
                    'locale' => $this->locale,
                    'target' => $target,
                    'params' => $params,// array_filter($params,array($this,'filterParam')),
                    'name' => $name
                );
            }
        }
        
        if($this->isHardRoutingEnabled)
            return $this->hardRouting($requestUrl, $locale);
        
        return false;
        /*
        if($r = $this->hardRouting($requestUrl, $locale))
        {
            $r['locale'] = $locale;
            return $r;
        }
        
        return false;
        */
    }
    
    /**
     * Tries to fetch the corresponding controls
     * by traversing the controllers dirs till a class is controller is found
     * @param String $requestURL
     * @param String $locale
     * @return string[$locale, $target, $params, $name]|false if not controller was found
     */
    protected function hardRouting($requestURL, $locale)
    {
        $segments = explode('/', trim($requestURL,'/'));
        
        $_path = APP_PATH.DS.'Controllers';
        $target = 'App\\Controllers';
        
        while(is_dir($_path) && count($segments)!=0)
        {
            $_path .= DS.ucfirst($segments[0]);
            $target .= '\\'.ucfirst(array_shift($segments));
        }
        
        if(class_exists($target))
        {
            if(count($segments))
                $target .= '@'.array_shift($segments);
            
            return array(
                'locale' => $locale,
                'target' => $target,
                'params' => $segments,
                'name'   => '_hard_routed',
            );
        }
            
        return false;
        
    }
    
    
    
    /**
     * Compile the regex for a given route (EXPENSIVE)
     */
    private function compileRoute($route) {
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            
            $matchTypes = $this->matchTypes;
            foreach($matches as $match) {
                list($block, $pre, $type, $param, $optional) = $match;
                
                if (isset($matchTypes[$type])) {
                    $type = $matchTypes[$type];
                }
                if ($pre === '.') {
                    $pre = '\.';
                }
                
                //Older versions of PCRE require the 'P' in (?P<named>)
                $pattern = '(?:'
                    . ($pre !== '' ? $pre : null)
                    . '('
                        . ($param !== '' ? "?P<$param>" : null)
                        . $type
                        . '))'
                            . ($optional !== '' ? '?' : null);
                            
                            $route = str_replace($block, $pattern, $route);
            }
            
        }
        return "`^$route$`u";
    }
    
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Filter $params values.
     * Removes the right / from eache value
     * @param string $value an entry from $params
     * @return string
     */
    public function filterParam($value){
        return rtrim($value,'/');
    }
}
