<?php
/**
* 
* cacheado
*/
class Inoves_Calls
{
	static private $_except=array();
	static private $_only=array();
	static private $_all=array();
	
	static private $_cacheCalls=array();
	
	
	//tem que retornar os callbacks contr/action contr/* e */action
	static public function callsFromURS(Inoves_URS $URS)
	{
		return self::calls($URS->controller, $URS->action);
	}
	
	
	static function calls($controller, $action){
		if(!isset(self::$_cacheCalls[$controller.$action]))
		{
			$reduceCallbacks = array_merge((array)self::$_except[$controller]['*'],(array)self::$_except[$controller][$action],(array)self::$_except['*'][$action]);
			$allCall = array_diff( self::$_all, $reduceCallbacks );
			ksort($allCall);
			self::_merge($allCall, (array)self::$_only[$controller][$action]);
			self::_merge($allCall, (array)self::$_only[$controller]['*']);
			self::_merge($allCall, (array)self::$_only['*'][$action]);
			ksort($allCall);
			self::$_cacheCalls[$controller.$action]=$allCall;
		}
		return self::$_cacheCalls[$controller.$action];
	}
	
	
	//returna um array com todos os callbacks
	// controller/action == controller/action, */action, controller/*
	static function existExcept($controller, $action=null)
	{
		if($action==null)
			list($controller,$action)=explode('/', $controller);
		if(isset(self::$_except[$controller][$action]))
			return self::$_except[$controller][$action];
		elseif(isset(self::$_except[$controller]['*']))
			return self::$_except[$controller]['*'];
		elseif(isset(self::$_except['*'][$action]))
			return self::$_except['*'][$action];
		return false;
	}
	
	
	static function existOnly($controller, $action=null)
	{
		if($action==null)
			list($controller,$action)=explode('/', $controller);
		if(isset(self::$_only[$controller][$action]))
			return self::$_only[$controller][$action];
		elseif(isset(self::$_only[$controller]['*']))
			return self::$_only[$controller]['*'];
		elseif(isset(self::$_only['*'][$action]))
			return self::$_only['*'][$action];
		return false;
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
//echo key($routes)." ->-> $callback <br>";
		if(key($routes)=='except')
		{
			self::addExcept($callback,$callback, $routes['except']);
			self::addAll($callback,$callback);
		}
		elseif(key($routes)=='only')
		{
			self::addOnly($callback,$callback, $routes['only']);
		}
		else
		{
			self::addAll($callback,$callback);
		}
	}
	
	
	/**
	 * Substitue um callback por outro
	 * @example:
	 * replace('Core::menu', 'Menu::menu', array('only'=>'menu/select'));
	 */
	static public function _replace($replace, $callback, $routes = array())
	{
		
		if(key($routes)=='except')
		{
			if(is_array($routes['except']))
			{
				foreach ($routes['except'] as $route) {
					list($c,$a)=explode('/', $route);
					self::$_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
				}
			}
			else
			{
				list($c,$a)=explode('/', $routes['except']);
				self::$_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
			}
		}
		elseif(key($routes)=='only')
		{
			if(is_array($routes['only']))
			{
				foreach ($routes['only'] as $route) {
					list($c,$a)=explode('/', $route);
					self::$_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
				}
			}
			else
			{
				list($c,$a)=explode('/', $routes['only']);
				self::$_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
			}
		}
		else
		{
			self::$_all[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
		}
	}
	
	
	static public function addExcept($index ,$callback, $except)
	{
		if(is_array($except))
		{
			foreach($except as $route)
			{
				list($c,$a)=explode('/', $route);
				self::$_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][Inoves_System::$currentOrder][$index] = explode('::',$callback);
			}
		}
		else
		{
			list($c,$a)=explode('/', $except);
			self::$_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][Inoves_System::$currentOrder][$index] = explode('::',$callback);
		}
	}
	
	
	static public function addOnly($index ,$callback, $only)
	{
		if(is_array($only))
		{
			foreach($only as $route)
			{
				list($c,$a)=explode('/', $route);
				self::$_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][Inoves_System::$currentOrder][$index] = explode('::',$callback);
			}
		}
		else
		{
			list($c,$a)=explode('/', $only);
			self::$_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][Inoves_System::$currentOrder][$index] = explode('::',$callback);
		}
	}
	
	
	static public function addAll($index ,$callback)
	{
		self::$_all[Inoves_System::$currentOrder][$index] = explode('::',$callback);
	}
	
	static private function _merge(&$a, $b){
	    $keys = array_keys($a);
	    foreach($keys as $key){
	        if(isset($b[$key])){
	            if(is_array($a[$key]) and is_array($b[$key])){
	                self::_merge($a[$key],$b[$key]);
	            }else{
	                $a[$key] = $b[$key];
	            }
	        }
	    }
	    $keys = array_keys($b);
	    foreach($keys as $key){
	        if(!isset($a[$key])){
	            $a[$key] = $b[$key];
	        }
	    }
	}
	
}