<?
/**
* 
*/
class Inoves_Partial
{
	private $_vars=array();
	private $_pathPartial;
	
	
	public function __get($name)
	{
		return $this->_vars[$name];
	}
	
	
	public  function __set($name,$value)
	{
		return $this->_vars[$name]=$value;
	}
	
	
	function __construct($pathPartial)
	{
		$this->_pathPartial=$pathPartial;
	}
	
	
	public function includePartial($value='')
	{
		include Inoves_System::instance()->pathModules .'/'.$value;
	}
	
	public function toString()
	{
		return $this->__toString();
	}
	
	public function __toString()
	{
		ob_start();
		include Inoves_System::instance()->pathModules .'/'.$this->_pathPartial;
		$output = ob_get_contents();
		ob_clean();
		return $output;
	}
}
