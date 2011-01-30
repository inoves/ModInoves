<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Widget extends Inoves_Modules
{
	
	
	//adiciona rotas
	static function setup()
	{
		Inoves_Routes::add('Widget::begin');//all
/*		Inoves_Routes::add('Menu::menuLeft');//all
		
		Inoves_Routes::add('Menu::menuContent', array('only'=>'menu/slug'));
		Inoves_Routes::add('Menu::homeContent', array('only'=>'/'));		
		//Inoves_View::setLayout( 'Core/partial/layout.phtml' );*/
		//todas as rotas, except todas as actions do controllers car
		//Inoves_Routes::add('Menu::all');
		//Inoves_Routes::add('Menu::menuItem', array('except'=>array('/')));
		//Inoves_Routes::add('Menu::title', array('only'=>array('ola/')));
	}
	
	
	public function begin()
	{
		//facebb
		$partial = new Inoves_Partial('Widget/partials/menu/widget.phtml');
		Inoves_View::addPartial('sidebar', $partial);
	}
	
	
	
}
