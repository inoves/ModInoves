<?php
// Define path to root directory
defined('PATH_ROOT')
    || define('PATH_ROOT', realpath(dirname(__FILE__) . '/../'));

//include paths
set_include_path( PATH_ROOT.
				  PATH_SEPARATOR.
				  PATH_ROOT.'/Modules/'.
				  PATH_SEPARATOR.
				  FRAME_PATH.'/Model/'.
				  PATH_SEPARATOR.
				  FRAME_PATH.'/Lib/');

//Autoload
include(PATH_ROOT.'/Zend/Loader/Autoloader.php');
Zend_Loader_Autoloader::getInstance()->registerNamespace('Inoves_');

if(Inoves_Cache::CACHE_OUTPUT && $_GET && Inoves_Cache::validOutput($_SERVER['REQUEST_URI'], 120)){
	echo Inoves_Cache::openOutput($_SERVER['REQUEST_URI']);
	exit;
}


//carrega URS
Inoves_URS::setRequest($_SERVER['REQUEST_URI']);


if(Inoves_Cache::CACHE_SYSTEM)
	Inoves_System::instanceMe(Inoves_Cache::load( 'Inoves_System_Instance' ));

//carrega modules e carrega call
Inoves_System::chargeModules( PATH_ROOT . '/Modules');


//retorna os os callbacks configurados nos modules
$calls = Inoves_Routes::calls(Inoves_URS::$controller, Inoves_URS::$action);


//Bootstrap file of modules
include PATH_ROOT.'/Config/bootstrap.php';


//executa os callbacks
Inoves_System::call($calls);

if(Inoves_Cache::CACHE_SYSTEM)
	Inoves_Cache::save( Inoves_System::instance(), 'Inoves_System_Instance' );


//only buffer output of site
if(Inoves_Cache::CACHE_OUTPUT){
	//Output store and handler
	$bufferOutput='';
	function ob_handler($value)
	{
		global $bufferOutput;
		$bufferOutput .= $value;
		return $value;
	}
	ob_start( 'ob_handler' );
} 

Inoves_View::show();

//stack buffer handlers
while (@ob_end_flush());


//maybe cache your output???
if( Inoves_Cache::CACHE_OUTPUT && $_GET )
	Inoves_Cache::saveOutput($bufferOutput, $_SERVER['REQUEST_URI']);
