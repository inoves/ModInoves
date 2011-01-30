<?php

//
$bufferOutput='';
function ob_handler($value)
{
	global $bufferOutput;
	$bufferOutput .= $value;
	return $value;
}

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
include(PATH_ROOT.'/Inoves/Loader.php');
$autoload = new Inoves_Loader();
include(PATH_ROOT.'/Inoves/Cache.php');


if(Inoves_Cache::CACHE_OUTPUT && $_GET && Inoves_Cache::validOutput($_SERVER['REQUEST_URI'], 120)){
	echo Inoves_Cache::openOutput($_SERVER['REQUEST_URI']);
	exit;
}

include(PATH_ROOT.'/Inoves/URS.php');
include(PATH_ROOT.'/Inoves/System.php');
include(PATH_ROOT.'/Inoves/Routes.php');
include(PATH_ROOT.'/Inoves/View.php');



//carrega URS
Inoves_URS::setRequest($_SERVER['REQUEST_URI']);


//carrega modules e carrega call
Inoves_System::chargeModules( PATH_ROOT . '/Modules');


//retorna os os callbacks configurados nos modules
$calls = Inoves_Routes::calls(Inoves_URS::$controller, Inoves_URS::$action);


include PATH_ROOT.'/Config/bootstrapApp.php';


//executa os callbacks
Inoves_System::call($calls);

//only buffer output of site
if(Inoves_Cache::CACHE_OUTPUT) ob_start( 'ob_handler' );

Inoves_View::show();
while (@ob_end_flush());

//maybe cache your output???
if( Inoves_Cache::CACHE_OUTPUT && $_GET )
	Inoves_Cache::saveOutput($bufferOutput, $_SERVER['REQUEST_URI']);
