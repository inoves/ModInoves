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
		
		Inoves_Routes::add('Menu::menuContent', array('only'=>'menu/slug'));
		Inoves_Routes::add('Menu::homeContent', array('only'=>'/'));		
		//Inoves_View::setLayout( 'Core/partial/layout.phtml' );
		//todas as rotas, except todas as actions do controllers car
		//Inoves_Routes::add('Menu::all');
		//Inoves_Routes::add('Menu::menuItem', array('except'=>array('/')));
		//Inoves_Routes::add('Menu::title', array('only'=>array('ola/')));
	}
	
	
	public function menuTop()
	{
		$partial = new Inoves_Partial('Menu/partials/menu/menuTop.phtml');
		Inoves_View::addPartial('menuTop', $partial);
	}
	
	
	public function menuLeft()
	{
		$partial = new Inoves_Partial('Menu/partials/menu/menuLeft.phtml');
		$partial->menus = array('menu1','menu2','menu3','menu4','menu5', 'menu6');
		Inoves_View::addPartial('sidebar', $partial);
	}
	
	//put action content from menu
	public function menuContent()
	{
		$partial = new Inoves_Partial('Menu/partials/page/menuContent.phtml');
		$partial->slug = Inoves_URS::$params[0];
		Inoves_View::addPartial('action', $partial);
	}
	
	public function homeContent()
	{
		$partial = new Inoves_Partial('Menu/partials/page/homeContent.phtml');
		$partial->slug = Inoves_URS::$params[0];
		Inoves_View::addPartial('action', $partial);
	}
	
	
}
