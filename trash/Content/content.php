<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Content extends Inoves_Modules
{
	public $order = 10;
	
	static function setup()
	{
		//index/index
		Inoves_Routes::add('Content::main', array('only'=>'index/index'));
		
		Inoves_Routes::add('Content::menu', array('only'=>'menu/slug'));
		
		Inoves_Routes::add('Content::submenu', array('only'=>'submenu/slug'));
		//Inoves_Routes::add('Core::okporque', array('only'=>array('ola/')));
		//Inoves_Routes::add('Core::title');
		//Inoves_Routes::add('Core::authenticated', array('except'=>array('/', 'login/*', 'logout/*', 'menu/*')));
	}
	
	
	//lista todos os itens do menu
	public function menu()
	{
		$partial = new Inoves_Partial('Content/view/menu/contentMain.phtml');

		$partial->slug = Inoves_URS::$params[0];
		
		Inoves_View::prepend('#content', $partial);
	}
	
	
	//lista todos os itens do menu
	public function submenu()
	{
		$partial = new Inoves_Partial('Content/view/submenu/contentMain.phtml');
		Inoves_View::prepend('#content', $partial);
	}
	
	//index
	public function main()
	{
		$partial = new Inoves_Partial('Content/view/index/contentMain.phtml');
		Inoves_View::prepend('#content', $partial);
	}
	
}