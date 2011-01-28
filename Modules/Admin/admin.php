<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Admin extends Inoves_Modules
{
	public $order = 10;
	
	static function setup()
	{
		Inoves_Routes::add('Admin::main', array('only'=>'admin/'));
		//Inoves_Routes::add('Admin::menu', array('except'=>'admin/'));//all
		//Inoves_Routes::add('Core::okporque', array('only'=>array('ola/')));
		//Inoves_Routes::add('Core::title');
		//Inoves_Routes::add('Core::authenticated', array('except'=>array('/', 'login/*', 'logout/*', 'menu/*')));
	}

	
	//index
	public function main()
	{
		$partial = new Inoves_Partial('Admin/view/index/contentMain.phtml');
		Inoves_View::prepend('#content', $partial);
	}
	
	
	//lista todos os itens do menu
	public function menu()
	{
		$partial = new Inoves_Partial('Admin/view/menu/contentMain.phtml');
		Inoves_View::prepend('#content', $partial);
	}
}