<?php


class Inoves_Cache
{
	
	const CACHE_OUTPUT 	= false;
	
	const CACHE_CORE 	= false;
	
	static public $cache = true;
	
	static private $_cache=null;
	
	
	
	public function validOutput($value, $ttl=120)
	{
		return (file_exists(PATH_ROOT . '/Cache/'. md5($value))  && filemtime( PATH_ROOT . '/Cache/'. md5($value)) < (time() + $ttl));
	}
	
	public function openOutput($value)
	{
		return file_get_contents(PATH_ROOT . '/Cache/'. md5($value)) ;
	}
	
	public function saveOutput($data, $value)
	{
		return file_put_contents(PATH_ROOT . '/Cache/'. md5($value), $data) ;
	}
	
	
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