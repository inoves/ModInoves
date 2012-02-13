<?
/*
view->set('bar');
$partil->set() == view->set()
view->add_partial('placeholder_name', $partial) == $partials[]=$partial

on partial:
	$this->view()->foo='valur bar'

	$this->view->placeholder('')==foeach include $partials[]-path()


view->
*/
class Inoves_View_Placeholder extends stdClass implements Inoves_View_Interface
{

	private $__partials=array();
	static private $__layout_placeholder = 'layout_core';

	/**
	 * 
	 * 
	 */
	public function add_partial($placeholder_name, $partial)
	{
		if(!is_null($partial->get_name()))
			self::instance()->__partials[$placeholder_name][$partial->get_name()] = $partial;
		else
			self::instance()->__partials[$placeholder_name][] = $partial;
	}

	/**
	 * 
	 * 
	 * 
	 */
	public function placeholder($placeholder_name)
	{
		if(isset($this->__partials[$placeholder_name]))
		foreach (self::instance()->__partials[$placeholder_name] as $partial){
			$partial->include_partial($partial->path());
		}
	}

	/**
	 * 
	 * 
	 *
	 */
	static private $__instance=null;
	static public function instance()
	{
		if(self::$__instance==null)
			self::$__instance=new self();
		return self::$__instance;
	}


	//statics
	static public function get($name)
	{
		return self::instance()->$name;
	}
	static public function set($name, $value)
	{
		return self::instance()->$name = $value;
	}
	static public function show()
	{	
		self::instance()->placeholder(self::$__layout_placeholder);
	}
	static public function set_layout($partial)
	{
		self::instance()->add_partial(self::$__layout_placeholder, $partial);
	}

	static public function exist_partials($placeholder_name)
	{
		return isset(self::instance()->__partials[$placeholder_name]);
	}

	public function view()
	{
		return self::instance();
	}

	public function include_partial($partial_path)
	{
		include Inoves_System::instance()->pathModules . '/' . $partial_path;
	}
}
