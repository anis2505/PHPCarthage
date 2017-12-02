<?php
namespace System\Libs\Template;


use System\Libs\Template\Exceptions\TemplatePartialsException;

/**
 * Class Partials
 * @package Darwin
 *
 * Partials rendering class.
 *
 */
class Partials
{

	/**
	*
	* @var string The full path to the partials directory.
	*/
	public $partialsDir;

	/**
	*
	* @var string the partial file extension.
	*/
	protected $partialExtension;


	public function __construct( $partialsDir, $partialExtension = 'php' )
	{
		 if(! is_dir( $partialsDir ))
            Throw new TemplatePartialsException( 'The partial directory '.$partialsDir.' does not exists.' );

		$this->partialsDir = $partialsDir;
		$this->partialExtension = $partialExtension;
	}

	/**
	* Partial rendering method.
	*
	* Render partials and return the resulting contents.
	*
	* @throws TemplatePartialsException when the requested partial was not found.
	*
	* @param string the requested partial file.
	* @param array the assigned data.
	*
	* @return string the partial rendered contents.
	*/
    public function renderPartial( $partial, $data = array() )
    {
        ob_start();
        
            extract($data);
            
            $filePath = $this->partialsDir.DS.str_replace( '/', DS, $partial ).'.'.$this->partialExtension;
            
            if( ! file_exists( $filePath ) )
                throw new TemplatePartialsException("The partial file {$partial} was not found", 404);
                
            include $filePath;
            
            $partialContents = ob_get_contents();
        
        ob_end_clean();

        return $partialContents;
    }

}
