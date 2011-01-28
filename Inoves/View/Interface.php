<?php
/**
* 
*/
interface Inoves_View_Interface
{
	
	static public function get($name);
	static public function set($name, $value);
	
	
	static public function init($_type);
	
	
	static public function setLayout($value='');
	
	
	static public function openDom($output);
	
	
	static public function append($query, $partial);
	
	
	static public function prepend($query, $partial);
	
	
	static public function replaceWith($query, $partial);
	
	
	static public function html($query, $partial);
	
	
	static public function show();
	
	
	static public function query($query);
	
}
