<?
/**
 * $this->variable_local
 * $this->view()->variable_global 
 * 
*/
class Inoves_Partial extends stdClass
{
	
	private $__pathPartial;
	private $__name=null;
	private $__vars=array();

	public function __get($name)
	{
		return (isset($this->$name))? $this->$name : Inoves_View::instance()->$name ;
		return Inoves_View::instance()->$name ;
	}
	
	public  function __set($name,$value)
	{
		return $this->$name = $value;
		return Inoves_View::instance()->$name = $value;
	}
	
	
	public function get_name()
	{
		return $this->__name;
	}
	public function set_name($name)
	{
		return $this->__name = $name;
	}


	public function view()
	{
		return Inoves_View::instance();
	}
	
	function __construct($pathPartial, $name=null)
	{
		$this->__name = $name;
		$this->__pathPartial=Inoves_System::instance()->pathModules . '/' .$pathPartial;
	}
	
	public function path()
	{
		return $this->__pathPartial;
	}

	public function toString()
	{
		return $this->__toString();
	}

	public function __toString()
	{
		return '';
		ob_start();
		include $this->path();
		$output = ob_get_contents();
		ob_clean();
		return $output;
	}

	public function include_partial($path)
	{
		include $path;
	}


	public function placeholder($placeholder_name)
	{
		Inoves_View::instance()->placeholder($placeholder_name);
	}

}
