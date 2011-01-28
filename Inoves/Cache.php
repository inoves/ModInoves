<?php


class Inoves_Cache
{
	static public $cache = true;
	
	
	
	
	static private $_cache=null;
	
	static public function instance(){
		if( is_null(self::$_cache) )
			self::_createInstance();
		return self::$_cache;
	}
	
	
	static private function _createInstance(){
		$frontendOptions = array(
			'lifetime' => 7200,
			'automatic_serialization' => true
		);
		$backendOptions = array(
			'cache_dir' => sys_get_temp_dir()
		);
		self::$_cache = Zend_Cache::factory('Core',
									 'File',
									 $frontendOptions,
									 $backendOptions);
	}
	
	
	static public function load($id)
	{
		return self::instance()->load($id);
	}
	
	
	static public function save($data, $id)
	{
		self::instance()->save($data, $id);
	}
}