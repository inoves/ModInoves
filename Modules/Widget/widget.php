<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Widget extends Inoves_Modules
{
	
	
	//adiciona rotas
	static function setup()
	{
		Inoves_Routes::add('Widget::begin', array('except'=>'/'));//all
	}
	
	
	public function begin()
	{
		//facebb
		$partial = new Inoves_Partial('Widget/partials/widget.phtml');
		$partial->widget_name = 'Hello Word';
		Inoves_View::add_partial('widgets', $partial);
	}
	
	
	
}
