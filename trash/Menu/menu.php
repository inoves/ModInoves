<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Menu extends Inoves_Modules
{
	
	//adiciona rotas
	static function setup()
	{
		Inoves_Routes::add('Menu::menuTop');//all
		Inoves_Routes::add('Menu::menuLeft');//all
		
		//Inoves_View::setLayout( 'Core/partial/layout.phtml' );
		//todas as rotas, except todas as actions do controllers car
		//Inoves_Routes::add('Menu::all');
		//Inoves_Routes::add('Menu::menuItem', array('except'=>array('/')));
		//Inoves_Routes::add('Menu::title', array('only'=>array('ola/')));
	}
	
	
	public function menuTop()
	{
		$partial = new Inoves_Partial('Menu/partial/menuTop.phtml');
		Inoves_View::append('#menuTop', $partial);
	}
	
	
	public function menuLeft()
	{
		$partial = new Inoves_Partial('Menu/partial/menuLeft.phtml');
		$partial->menus = array('menu1','menu2','menu3','menu4','menu5', 'menu6');
		Inoves_View::prepend('#content', $partial);
	}
	
	
}
