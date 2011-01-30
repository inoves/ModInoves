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
	
	//Get variables
	static public function get($name)
	{
		return self::$_vars[$name];
	}
	
	//set variables
	static public function set($name, $value)
	{
		return self::$_vars[$name]=$value;
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
	
	/**
	 * * Inoves_View_HTML::getPartials('nameArea');
	* Inoves_View_HTML::setPartials('nameArea', $partial);
	 */
	static public function existPartials($partialArea)
	{
		return isset(self::$_partials[$partialArea]);
	}
	
	static public function includePartial($value='')
	{
		include Inoves_System::$pathModules . $value;
	}
	
	static public function addPartial($partialArea, Inoves_Partial $partial)
	{
		self::$_partials[$partialArea] .= $partial->toString();
	}
	
	
	static public function show()
	{
		//ob_start();
			include Inoves_System::$pathModules .'/'.self::$_layout;
		//$output = ob_get_contents();
		//ob_clean();
		//return $output;
	}
	
	
	
}
