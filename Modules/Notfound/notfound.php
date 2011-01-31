<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Notfound extends Inoves_Modules
{
	
	//deve ser sempre o ultimo controller a executar
	public $order = 1000;
	
	
	static function setup()
	{
		Inoves_Routes::add('Notfound::run');
	}
	
	
	//lista todos os itens do menu
	public function run()
	{
		//não existe partials na area action
		if (!Inoves_View::existPartials('action')):
			$partial = new Inoves_Partial('NotFound/partial/notfoundContent.phtml');
			Inoves_View::addPartial('action', $partial);
		endif;
	}
	
	
}