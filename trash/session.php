<?php
/**
* Manipula sessions
* Para criar algo mais escalavel altere esta funções.
*
*/
class Session
{
	public static function get($name)
	{
		return $_SESSION[$name];
	}
	public static function set($name, $value){
		$_SESSION[$name]=$value;
		return self::get($name);
	}
	public static function rm($name){
		unset($_SESSION[$name]);
	}
	public static function get_all(){
		return $_SESSION;
	}
}
