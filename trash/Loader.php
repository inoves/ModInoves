<?php
/**
* 
*/
class Inoves_Loader
{
	
	//Coloca no stack o autoload
	function __construct()
	{
		//cache:Frame_URS::$requestId = base_convert(md5($_SERVER['']+serialize($_REQUEST)), 32, 38);
		spl_autoload_register(array($this, 'load'));
	}
	
	
	//
	static function load($className)
	{
		//$locationClass = FRAME_PATH.DIRECTORY_SEPARATOR.str_replace("_", DIRECTORY_SEPARATOR, $className) . '.php';
		$locationClass = str_replace("_", DIRECTORY_SEPARATOR, $className) . '.php';
		//echo " $locationClass <br>";
		self::includeNow($locationClass);
	}
	
	
	static function includeNow($locationClass)
	{
		return include_once $locationClass;
	}
	
}
