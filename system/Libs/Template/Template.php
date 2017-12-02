<?php
namespace System\Libs\Template;
/**
 * Created by PhpStorm.
 * User: anis
 * Date: 8/10/15
 * Time: 6:46 PM
 */


/**
 * Class Template
 * @package libs
 *
 * Simple templating engine.
 *
 * Simple templating engine uses native Php markup.
 * So no compilation or alternative syntax are needed.
 * Inspired by Plates Php templating engine.
 *
 */



use System\Loader;
use System\Libs\Cache\Cache;
use System\Libs\Template\Exceptions\TemplateException;
use System\Libs\Template\Exceptions\TemplateVariablesException;
use \Opis\Closure as OpisC;
//use function \Opis\Closure\serialize as serializer;//, unserialize as u}


class Template
{


    /**
     * @var array the template data
     */
    protected $data = array();

    /**
     * @var array the blocks
     */
    protected $blocks = array();

    /**
     * @var array the blocks
     */
    protected $blocksData = array();

    /**
     * @var array the block's parents.
     */
    protected $parents = array();

    /**
     * @var array the loaded plugins
     */
    protected $plugins = array();

    /**
     * @var string the rendered template
     */
    protected $template = '';

    /**
     * @var string The template's root directory
     */
    protected $templatesDir = __DIR__;
    
    /**
     * @var string The template's layouts directory
     */
    protected $layoutsDir = __DIR__;

    protected $partial;

    /**
     * @var string the layout of the current loaded template.
     */
    protected $layout = '';

    /**
     * @var string The template file extension By default 'php'
     */
    protected $templateExtension = 'php';
    
    public $container;
    
    public $cache;
    
    public $cache_enabled;


    public function __construct()
    {
        
        $this->cache = Cache::getInstance('File');
        
        $this->templateExtension = Loader::$configs['configs']['template']['extension'];
        
        $this->setTemplatesDir( Loader::$configs['configs']['template']['templates_dir'] );
        
        $this->layoutsDir = str_replace('.', DS, Loader::$configs['configs']['template']['layouts_dir']);
        //$this->layoutsDir = APP_PATH.DS.str_replace('.', DS, Loader::$configs['configs']['template']['layouts_dir']);
        
        $partialsDir = APP_PATH.DS.str_replace('.', DS, Loader::$configs['configs']['template']['partials_dir']);

        $this->partial = new Partials( $partialsDir, $this->templateExtension);
        
        $this->cache_enabled = Loader::$configs['configs']['template']['cache_enabled'];
        
        $this->loadDefautlPlugins(Loader::$configs['configs']['template']['plugins']);
    }
    
    protected function loadDefautlPlugins($plugins)
    {
        foreach($plugins as $plugin)
            if(class_exists($plugin))
                $this->addPlugin(new $plugin());
            
    }

    /**
     * Prepare the template and data to be rendered to the user.
     * Throws exception if the template file does not exist.
     *
     * @param $template
     * @param array $data
     * @throws \Exception
     *
     */
    public function render( $template, $data = array() )
    {
        if( ! $this->checkTemplate( $template ) )
            throw new TemplateException( 'The template file '. $template .' does not exists.' );

        $this->template = $template;
        
        $this->data = array_merge( $this->data, $data );
        
        $key = sha1($this->template.OpisC\serialize($this->data));
        
        if($this->cache != false && $this->cache_enabled)
        {
            $page = $this->cache->getFullPage($key);
            if(null != $page)
            {
                echo $page;
                return;   
            }
        }
        
        $contents = $this->display();
        ($this->cache != false && $this->cache_enabled)?$this->cache->setFullPage($key,$contents):null;

    }

    /**
     * Add a variable to the template.
     *
     * @param string $name the variable name.
     * @param mixed $var the variable itself.
     *
     */
    public function assign( $name, $var )
    {
        $this->data[$name] = $var;
    }

    /**
     * Sets the template's root dir.
     * Throws exception if the directory does not exist.
     *
     * @param $templatesDir
     * @throws \Exception
     *
     */
    public function setTemplatesDir( $templatesDir )
    {
        if(! is_dir( APP_PATH.DS.str_replace('.', DS, $templatesDir)))
            Throw new TemplateException( 'The Template directory '.$templatesDir.' does not exists.' );

            $this->templatesDir = APP_PATH.DS.str_replace('.', DS, $templatesDir);
    }

    /**
     * Sets the template file extension.
     *
     * @param $extension
     *
     */
    public function setTemplateExtension( $extension )
    {
        $this->templateExtension = $extension;
    }

    /**
     * Add a new plugin.
     *
     * @param $instance
     *
     */
    public function addPlugin( $instance )
    {
        $instance->init( $this );
    }

    /**
     * Register a new plugin method.
     *
     * @param $name
     * @param $object
     * @param $method
     *
     */
    public function register( $name, &$object, $method )
    {
        $this->plugins[$name] = array( $object, $method );
    }

    /**
     * Call a plugin method.
     *
     * @param $name
     * @param $params
     * @return mixed
     *
     */
    public function __call( $name, $params )
    {
        if( array_key_exists( $name, $this->plugins ) )
        {
            return call_user_func_array( $this->plugins[$name], $params );
        }
    }

    /**
     * Gets data from the rendered variables.
     *
     * Returns the full rendered data.
     * Or simply a field value.
     *if the field does not exist null value is returned.
     *
     * @param null $name
     * @return mixed|array|null
     *
     */
    public function getData( $name = null )
    {
        if( is_null( $name ) )
            return $this->data;

        if( array_key_exists( $name, $this->data ) )
            return $this->data[$name];

        return null;

    }

    /**
     * Return the full file path.
     * starting from the templates dir folder.
     *
     * @param $file the template file name
     * @return string The full template path
     *
     */
    protected function getFile( $file )
    {
        return $this->templatesDir.DS.strtr($file, '.', DS).'.'.$this->templateExtension;
    }

    /**
     * Checks if a template file exists.
     *
     * @param $template The template name
     * @return bool true if the template exists, false if not
     *
     */
    protected  function checkTemplate( $template )
    {
        //echo $this->getFile($template);
        if(file_exists( $this->getFile( $template) ))
            return true;

        return false;
    }


    /**
     * Display the rendered template to the user.
     * Throws exception. if a template file or layout does not exist.
     *
     * @throws \Exception
     *
     *
     */
    protected function display()
    {
        $contents = '';
        try
        {
            
            ob_start( array( &$this, 'sanitizeOutput' ) );

            require_once $this->getFile( $this->template );
            
            while( $this->layout !== '' )
            {
                $this->clearParents();
                

                if(  ! $this->checkTemplate( $this->layout ) )
                    throw new TemplateException('The layout file '.$this->layout.' does not exists.');

                $filePath = $this->getFile( $this->layout );

                $this->layout = '';
                
                include_once $filePath;
            }

            if( ob_get_level() )
            {
                $contents = ob_get_contents();
                ob_end_flush();
            }
        }
        catch ( \Exception $genealException )
        {
            if( ob_get_level() )
                ob_end_clean();

            throw $genealException;
        }
        
        return $contents;

    }

    /**
     * Starts a block.
     *
     * @param $block the block name.
     */
    public function startblock( $block )
    {
        array_unshift( $this->blocks, $block );

        array_unshift( $this->parents, $block );

        ob_start( array( &$this, 'sanitizeOutput' ) );
    }

    /**
     * Ends a block and returns it's contents.
     *
     * @return string the block contents.
     */
    public function endblock()
    {
        if( empty( $this->blocks ) )
            return;

        $block = $this->blocks[0];

        if( ! $this->checkBlock( $block ) )
        {
            $this->blocksData[$block] = ob_get_contents();
        }
        ob_end_clean();

        if( $this->layout === '' OR $this->hasParents() )
        {
            array_shift( $this->blocks );
            echo $this->blocksData[$block];
        }

        array_shift( $this->parents );

    }




    /**
     * Basic output sanitizing.
     * using Php's mb_convert_encoding and htmlentities functions.
     *
     * @param $value
     * @return string
     *
     */
    public function e( $value )
    {
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Includes a file.
     *
     * @param string the file name to be include.
     *
     * if the file does not exist simple it will ignored.
     *
     *
     */
    public function insert( $file )
    {
        if( $this->checkTemplate( $file ) )
                return include_once $this->getFile( $file );
    }

    /**
     * Render partial files.
     *
     * @param string the partial file.
     * @param array the data parsed by the partial
     *
     *
     */
    public function partial( $parial, $data = array() )
    {
        return $this->partial->renderPartial( $parial, $data );
    }

    /**
     * Checks if a block data was set or not.
     *
     * @param $name the block name.
     * @return bool
     */
    protected function checkBlock( $name )
    {
        if( ! array_key_exists( $name, $this->blocksData ) )
            return false;

        return true;
    }

    /**
     * @return bool Checks if a block has a parents.
     */
    protected function hasParents()
    {
        if( count( $this->parents ) < 2 )
            return false;

        return true;
    }

    /**
     * Clears the parents array.
     */
    protected function clearParents()
    {
        $this->parents = array();
    }

    /**
     * Sets a layout file for the current template.
     *
     * @param String $layout the layout file
     */
    public function setlayout( $layout )
    {
        $this->layout = $this->layoutsDir.DS. str_replace('.', DS, $layout);
    }

    /**
     * Clear all data.
     *
     */
    public function clearData()
    {
        $this->data = array();
        $this->blocks = array();
        $this->blocksData = array();
        $this->parents = array();
        $this->layout = '';
    }


    protected function sanitizeOutput( $buffer )
    {
        $buffer = trim($buffer);

        /**
         * Remove comment if you want to strip all white spaces out of the contents.
         * All content will be one long single line.
         */

        /*
        $search = array(
            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );

        $replace = array(
            '>',
            '<',
            '\\1'
        );

        $buffer = preg_replace($search, $replace, $buffer);
        */
        return $buffer;
    }
    
    public function __get($name)
    {
        
        if(isset( $this->data[$name])) 
        {
            return is_object($this->data[$name])?$this->data[$name]:$this->e($this->data[$name]);
        }
        
        throw new TemplateVariablesException("Undefined variable: ".$name);
    }

}


