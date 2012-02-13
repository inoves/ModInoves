<?php
/**
* 
*/
require_once PATH_ROOT.'/Lib/phpQuery/phpQuery.php';

//implements Inoves_View_interface
class Inoves_View_DOM implements Inoves_View_Interface
{
	
	static private $_layout = '';
	
	static private $_dom;
	
	static private $_vars=array();
	
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
		ob_start();
			include Inoves_System::instance()->pathModules .'/'. self::$_layout;
		$output = ob_get_contents();
		ob_clean();
		self::openDom($output);
	}
	
	
	static public function setLayout($value='')
	{
		self::$_layout = $value;
	}
	
	
	//no final
	static public function openDom($output)
	{
		self::$_dom = phpQuery::newDocumentHTML($output);//newDocumentFileXHTML();
	}
	
	
	static public function append($query, $partial)
	{
		self::$_dom[$query]->append((is_string($partial))?$partial:$partial->toString());
	}
	
	
	static public function prepend($query, $partial)
	{
		self::$_dom[$query]->prepend((is_string($partial))?$partial:$partial->toString());
	}
	
	static public function replaceWith($query, $partial)
	{
		self::$_dom[$query]->replaceWith((is_string($partial))?$partial:$partial->toString());
	}
	
	static public function html($query, $partial)
	{
		self::$_dom[$query]->html((is_string($partial))?$partial:$partial->toString());
	}
	
	static public function show()
	{
		return self::$_dom->htmlOuter();
	}
	
	
	static public function query($query)
	{
		return self::$_dom[$query];
	}
	
	
}
