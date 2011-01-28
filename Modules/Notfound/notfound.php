<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Notfound extends Inoves_Modules
{
	
	public $order = 100;
	
	static function setup()
	{
		Inoves_Routes::add('Notfound::run');
	}
	
	
	//lista todos os itens do menu
	public function run()
	{
		//var_dump(Inoves_View::query('#contentMain'));
		if(count( Inoves_View::query('#contentMain')->elements )==0){
			$partial = new Inoves_Partial('NotFound/partial/contentMain.phtml');
			Inoves_View::prepend('#content', $partial);
		}
	}
	
	
}