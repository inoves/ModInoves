<?php
/**
* UNIFORM RESOURCE SYSTEM
*/
class Inoves_URS
{
	static public $controller;
	static public $action;
	static public $params=array();
	
	const CONTROLLER_DEFAULT = 'index';
	const ACTION_DEFAULT 	 = 'index';
	
	
	static public function getParam($id)
	{
		return self::$params[$id];
	}
	
	
	//controller/action == controller/action || controller/action==controller/* || controller/action==*/action
	static public function equal( Inoves_URS $URS)
	{
		return (
			(self::$controller===$URS->$controller && self::$action===$URS->action)
			||
			('*'===$URS->$controller && self::$action===$URS->action)
			||
			(self::$controller===$URS->$controller && '*'===$URS->action)
			);
	}
	
	//setters
	static public function setController($value='')
	{
		self::$controller=($value)?strtolower($value):Inoves_URS::CONTROLLER_DEFAULT;
	}
	static public function setAction($value='')
	{
		self::$action=($value)?strtolower($value):Inoves_URS::ACTION_DEFAULT;
	}
	
	//controller/action/param1/param2/param3...
	static public function setRequest($rawRequest)
	{
		self::parseRequest($rawRequest);
	}
	
	static public function parseRequest($rawRequest)
	{
		list($requestUrs, $rawParams)=explode('?', $rawRequest);
		list($c,$a,$params)=explode('/',  substr($requestUrs, 1));
		parse_str($rawParams, self::$params);
		self::setController($c);
		self::setAction($a);
		if (!is_array($params))
			self::$params[0] = $params;
		else
			self::$params = $params + self::$params;
	}
	
	static public function setURS($c,$a)
	{
		self::setController($c);
		self::setAction($a);
	}
}