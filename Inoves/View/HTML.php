<?php
/**
* Inoves_View_HTML::getPartials('nameArea');
* Inoves_View_HTML::setPartials('nameArea', $partial);
*/
class Inoves_View_HTML
{
	
	static private $_layout = '';
	
	
	static private $_vars=array();
	
	
	static private $_partials=array();
	
	
	static public function get($name)
	{
		return self::$_vars[$name];
	}
	
	static public function set($name, $value)
	{
		return self::$_vars[$name]=$value;
	}
	
	
	static public function init()
	{
		
	}
	
	
	static public function setLayout($value='')
	{
		self::$_layout = $value;
	}
	
	/**
	 * * Inoves_View_HTML::getPartials('nameArea');
	* Inoves_View_HTML::setPartials('nameArea', $partial);
	 */
	static public function getPartials($partialArea)
	{
		return self::$_partials[$partialArea];
	}
	
	
	static public function setPartial($partialArea, Inoves_Partial $partial)
	{
		self::$_partials[$partialArea] .= $partial->toString();
	}
	
	static public function show()
	{
		ob_start();
			include PATH_ROOT.'/Modules/'.self::$_layout;
		$output = ob_get_contents();
		ob_clean();
	}
	
	
	
}
