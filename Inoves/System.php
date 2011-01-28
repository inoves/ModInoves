<?php
/**
* 
* 
* 
* cacheado
*/

class Inoves_System
{
	static private $_AddOns;
	static private $_cacheAddOns;
	
	static public $currentController;
	static public $currentAction;
	static public $currentOrder;
	
	static public  $pathModules;
	
	
	//Carrega addons
	static public function chargeModules( $pathModulesDirectory )
	{
		Inoves_System::$pathModules = $pathModulesDirectory;
		//if( (self::$_AddOns=Inoves_Cache::load('Inoves_System_AddOns'))===false){
			if(!isset(self::$_AddOns)){
				$dir = new DirectoryIterator($pathModulesDirectory);
				foreach ($dir as $fileinfo) {
				    if (!$fileinfo->isDot() && $fileinfo->isDir()){
						include $fileinfo->getPathname(). '/' . $fileinfo->getFilename().'.php';
						$class = ucfirst($fileinfo->getFilename());
						$prop = get_class_vars($class);
						$order = 10+(int)$prop['order'];
						self::$_AddOns[$order][] = $class;
				    }
				}
				ksort(self::$_AddOns);
				Inoves_Cache::save(self::$_AddOns, 'Inoves_System_AddOns');
			}			
		//}
		self::setupModules();
	}
	
	
	//carrega routes
	static public function setupModules()
	{
		foreach (self::$_AddOns as $order => $modules) {
			foreach ($modules as  $module){
				self::$currentOrder = $order;//travel
				$module = ucfirst($module);
				if(method_exists($module, 'setup')){
//echo "Module: $module <br>";
					$moduleObject = new $module();
					$moduleObject->setup();//chama
				}
			}
		}
	}
	
	static public function call($callbacksAr)
	{
		foreach ($callbacksAr as $callbacks) {
			foreach($callbacks as $key => $callback){
				$controller = $callback[0];
				$action = $callback[1];
				self::$currentController = $controller;
				self::$currentAction = $action;
				//die;
				$objClass = new $controller;
//echo " call: $controller -> $action <br/>";
				$objClass->$action();
			}
		}
	}
	
}
