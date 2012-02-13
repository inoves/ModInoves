<?php
/**
* controller/actionName/params[0]/params[1]/params[2]/?foo=bar
*/
class Menu extends Inoves_Modules
{
	//public $order = 10;

	//adiciona rotas
	static function setup()
	{
		Inoves_Routes::add('Menu::menuTop', array('except'=>'menu/slug'));//all
		Inoves_Routes::add('Menu::menuLeft');//all
		Inoves_Routes::add('Menu::menuContent', array('only'=>'menu/slug'));
		Inoves_Routes::add('Menu::homeContent', array('only'=>'/'));

		
	}
	
	
	public function menuTop()
	{
		$partial = new Inoves_Partial('Menu/partials/menu/menuTop.phtml');
		Inoves_View::add_partial('menuTop', $partial);
	}
	
	
	public function menuLeft()
	{
		$partial = new Inoves_Partial('Menu/partials/menu/menuLeft.phtml');
		$partial->menus = array('menu1','menu2','menu3','menu4','menu5', 'menu6');
		Inoves_View::add_partial('sidebar', $partial);
	}
	
	//put action content from menu
	public function menuContent()
	{
		$partial = new Inoves_Partial('Menu/partials/page/menuContent.phtml');
		$partial->slug = Inoves_URS::$params[0];
		Inoves_View::add_partial('action', $partial);
	}
	
	public function homeContent()
	{
		$partial = new Inoves_Partial('Menu/partials/page/homeContent.phtml');
		$partial->slug = Inoves_URS::$params[0];
		Inoves_View::add_partial('action', $partial);
	}

}
