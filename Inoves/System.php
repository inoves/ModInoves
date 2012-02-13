<?php
/**
* 
* 
* 
* cacheado
*/

class Inoves_System
{
	private $_AddOns;
	private $_cacheAddOns;
	
	public $currentController;
	public $currentAction;
	public $currentOrder;
	
	public  $pathModules;
	
	static private $_except=array();
	static private $_only=array();
	static private $_all=array();

	static private $_cacheCalls=array();
	
	static private $_instance=null;
	
	
	
	
	static public function instance()
	{
		if( is_null(self::$_instance) || self::$_instance==false )
			self::$_instance = new self();
		return self::$_instance;
	}
	
	
	static public function instanceMe($instance){
		self::$_instance = $instance;
	}
	
	
	static public function serialize(){
		return serialize(self::instance());
	}
	
	
	
	
	//Carrega addons
	static public function chargeModules( $pathModulesDirectory )
	{
		self::instance()->pathModules = $pathModulesDirectory;
		if(!isset(self::instance()->_AddOns)){
			$dir = new DirectoryIterator($pathModulesDirectory);
			foreach ($dir as $fileinfo) {
			    if (!$fileinfo->isDot() && $fileinfo->isDir()){
					include_once $fileinfo->getPathname(). '/' . strtolower($fileinfo->getFilename()).'.php';
					$class = ucfirst($fileinfo->getFilename());
					$prop = get_class_vars($class);
					$order = 10+(int)$prop['order'];
					self::instance()->_AddOns[$order][] = $class;
			    }
			}
			ksort(self::instance()->_AddOns);
			self::instance()->setupModules();
		}
	}
	
	
	//carrega routes
	static public function setupModules()
	{
		foreach (self::instance()->_AddOns as $order => $modules){
			foreach ($modules as  $module){
				self::instance()->currentOrder = $order;//travel
				$module = ucfirst($module);
				if(method_exists($module, 'setup')){
					$moduleObject = new $module();
					$moduleObject->setup();
				}
			}
		}
	}
	
	static public function call($callbacksAr)
	{
		foreach ($callbacksAr as $callbacks) {//by order
			foreach($callbacks as $key => $callback){
				$controller = $callback[0];
				$action = $callback[1];
				self::instance()->currentController = $controller;
				self::instance()->currentAction = $action;
				include_once self::instance()->pathModules.'/'.$controller.'/'.strtolower($controller).'.php' ;
				$objClass = new $controller;
//echo " call: $controller -> $action <br/>";
				$objClass->$action();
			}
		}
	}
	
	
	static public function redirect($value='', $exit=true)
	{
		header('location: '. $value);
		if($exit) exit(0);
	}
	
	
	
	
	//tem que retornar os callbacks contr/action contr/* e */action
	static public function callsFromURS(Inoves_URS $URS)
	{
		return self::calls($URS->controller, $URS->action);
	}
	
	
	static function calls($controller, $action){
		
		if(!isset(self::instance()->_cacheCalls[$controller.$action]))//from serialize
		{
			$reduceCallbacks = array();
			$reduceCallbacks = array_merge((array)self::instance()->_except[$controller]['*'],(array)self::instance()->_except[$controller][$action],(array)self::instance()->_except['*'][$action]);
			$allCall = self::instance()->_all;
			self::_merge($allCall, (array)self::instance()->_only[$controller][$action]);
			self::_merge($allCall, (array)self::instance()->_only[$controller]['*']);
			self::_merge($allCall, (array)self::instance()->_only['*'][$action]);
			ksort($allCall);
			foreach( $allCall as $k => $all){
				$allCall[$k] = array_diff_key( $all, $reduceCallbacks) ;
			}
			self::instance()->_cacheCalls[$controller.$action] = $allCall;
		}
		return self::instance()->_cacheCalls[$controller.$action];
	}
	
	
	//returna um array com todos os callbacks
	// controller/action == controller/action, */action, controller/*
	static function existExcept($controller, $action=null)
	{
		if($action==null)
			list($controller,$action)=explode('/', $controller);
		if(isset(self::instance()->_except[$controller][$action]))
			return self::instance()->_except[$controller][$action];
		elseif(isset(self::instance()->_except[$controller]['*']))
			return self::instance()->_except[$controller]['*'];
		elseif(isset(self::instance()->_except['*'][$action]))
			return self::instance()->_except['*'][$action];
		return false;
	}
	
	
	static function existOnly($controller, $action=null)
	{
		if($action==null)
			list($controller,$action)=explode('/', $controller);
		if(isset(self::instance()->_only[$controller][$action]))
			return self::instance()->_only[$controller][$action];
		elseif(isset(self::instance()->_only[$controller]['*']))
			return self::instance()->_only[$controller]['*'];
		elseif(isset(self::instance()->_only['*'][$action]))
			return self::instance()->_only['*'][$action];
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
		if(key($routes)=='only'){
			self::addOnly($callback, $callback, $routes['only']);
		}else{
			self::addAll($callback, $callback);
			if(key($routes)=='except')
				self::addExcept($callback, $callback, $routes['except']);
		}
		/*
		if(key($routes)=='except')
		{
			self::addExcept($callback, $callback, $routes['except']);
			self::addAll($callback, $callback);
		}
		elseif(key($routes)=='only')
		{
			self::addOnly($callback, $callback, $routes['only']);
		}
		else
		{
			self::addAll($callback, $callback);
		}*/
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
					self::instance()->_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
				}
			}
			else
			{
				list($c,$a)=explode('/', $routes['except']);
				self::instance()->_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
			}
		}
		elseif(key($routes)=='only')
		{
			if(is_array($routes['only']))
			{
				foreach ($routes['only'] as $route) {
					list($c,$a)=explode('/', $route);
					self::instance()->_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
				}
			}
			else
			{
				list($c,$a)=explode('/', $routes['only']);
				self::instance()->_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
			}
		}
		else
		{
			self::instance()->_all[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$replace] = explode('::',$callback);
		}
	}
	
	
	static public function addExcept($index ,$callback, $except)
	{
		if(is_array($except))
		{
			foreach($except as $route)
			{
				list($c,$a)=explode('/', $route);
				self::instance()->_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$index] = explode('::',$callback);
			}
		}
		else
		{
			list($c,$a)=explode('/', $except);
			self::instance()->_except[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][$index] = explode('::',$callback);
		}
	}
	
	
	static public function addOnly($index ,$callback, $only)
	{
		if(is_array($only))
		{
			foreach($only as $route)
			{
				list($c,$a)=explode('/', $route);
				self::instance()->_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][self::instance()->currentOrder][$index] = explode('::',$callback);
			}
		}
		else
		{
			list($c,$a)=explode('/', $only);
			self::instance()->_only[($c!='')?strtolower($c):Inoves_URS::CONTROLLER_DEFAULT][($a!='')?strtolower($a):Inoves_URS::ACTION_DEFAULT][self::instance()->currentOrder][$index] = explode('::',$callback);
		}
	}
	
	
	static public function addAll($index ,$callback)
	{
		self::instance()->_all[self::instance()->currentOrder][$index] = explode('::',$callback);
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
