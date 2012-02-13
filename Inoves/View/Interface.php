<?php
/**
* 
*/
interface Inoves_View_Interface
{
	public function add_partial($placeholder_name, $partial);
	public function placeholder($placeholder_name);
	static public function instance();
	static public function show();
	static public function set_layout($partial);
	static public function exist_partials($placeholder_name);
	public function view();
	public function include_partial($partial_path);
	/*
	static public function init($_type);
	
	
	static public function openDom($output);
	
	
	static public function append($query, $partial);
	
	
	static public function prepend($query, $partial);
	
	
	static public function replaceWith($query, $partial);
	
	
	static public function html($query, $partial);
	
	
	static public function show();
	
	
	static public function query($query);
	*/
}
