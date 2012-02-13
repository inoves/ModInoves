<?php
/**
* controller/actionName/request0/request1/request2/...
*/
class Core extends Inoves_Modules_Core
{
	
	static function setup()
	{
		Inoves_View::setLayout( 'Core/layout/layout.html' );

		//only inicio
		//Inoves_Routes::add('Core::contentMain', array('only'=>'/'));//
		//Inoves_Routes::add('Core::okporque', array('only'=>array('ola/')));
		//Inoves_Routes::add('Core::title');
		//Inoves_Routes::add('Core::authenticated', array('except'=>array('/', 'login/*', 'logout/*', 'menu/*')));
	}
	
}