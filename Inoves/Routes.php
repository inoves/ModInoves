<?php
/**
* 
* cacheado
*/
class Inoves_Routes
{

	
	static public function callsFromURS(Inoves_URS $URS)
	{
		return self::calls($URS->controller, $URS->action);
	}
	
	
	static function calls($controller, $action){
		return Inoves_System::calls($controller, $action);
	}
	
	
	//returna um array com todos os callbacks
	// controller/action == controller/action, */action, controller/*
	static function existExcept($controller, $action=null)
	{
		return Inoves_System::existExcept($controller, $action);
	}
	
	
	static function existOnly($controller, $action=null)
	{
		return Inoves_System::existOnly($controller, $action);
	}
	
	
	/*
	$_except['controller']['action']['callback']='callback';
	$_only['controller']['action']['callback']='callback';
	$_all['controller']['action']['callback']='callback';
	
	add('object::function', array('except'=>'/'));
	add('object::function', array('only'=>'/'));
	add('object::function');
	*/
	static public function add($callback, array $routes = array())
	{
		return Inoves_System::add($callback, $routes);
	}
	
	
	/**
	 * Substitue um callback por outro
	 * @example:
	 * replace('Core::menu', 'Menu::menu', array('only'=>'menu/select'));
	 */
	static public function _replace($replace, $callback, $routes = array())
	{
		return Inoves_System::_replace($replace, $callback, $routes);
	}
	
	
	static public function addExcept($index ,$callback, $except)
	{
		return Inoves_System::addExcept($index, $callback, $except);

	}
	
	
	static public function addOnly($index ,$callback, $only)
	{
		return Inoves_System::addOnly($index, $callback, $only);
	}
	
	
	static public function addAll($index ,$callback)
	{
		return Inoves_System::addAll($index, $callback);
	}
	
	static private function _merge(&$a, $b){
	    return Inoves_System::_merge($a, $b);
	}
	
}