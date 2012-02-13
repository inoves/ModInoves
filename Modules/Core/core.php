<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Core extends Inoves_Modules_Core
{
	static function setup()
	{
		Inoves_Routes::add('Core::layout');//all
	}
	
	
	function layout()
	{
		$partial = new Inoves_Partial('Core/layout/layout.html');

		Inoves_View::set_layout($partial);
	}
}