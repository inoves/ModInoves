<?php
/**
* Inoves_View_HTML::getPartials('nameArea');
* Inoves_View_HTML::setPartials('nameArea', $partial);
*/
class Inoves_View_HTML extends stdClass implements Inoves_View_Interface
{
	
	private $_layout = '';
	
	
	private $_vars=array();
	
	
	private $_partials=array();

	
	static private $_instance=null;


	public function instance()
	{
		if(self::$_instance==null)
			self::$_instance = new self();
		return self::$_instance;
	}

	
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
		include Inoves_System::instance()->pathModules . $value;
	}
	
	static public function addPartial($partialArea, Inoves_Partial $partial)
	{
		self::$_partials[$partialArea] .= $partial->toString();
	}
	
	
	static public function show()
	{
		if(Inoves_Cache::CACHE_OUTPUT) 
			ob_start();
			
			include_once Inoves_System::instance()->pathModules .'/'.self::$_layout;
		
		if(Inoves_Cache::CACHE_OUTPUT){ 
			$output = ob_get_contents();
			ob_clean();
			return $output;
		}
	}
	
	
	
}
