<?php
//ob_start();
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


//carrega URS
Inoves_URS::setRequest($_SERVER['REQUEST_URI']);


//carrega modules e carrega call
Inoves_System::chargeModules( PATH_ROOT . '/Modules');


//retorna os os callbacks configurados nos modules
$calls = Inoves_Routes::calls(Inoves_URS::$controller, Inoves_URS::$action);


include PATH_ROOT.'/Config/bootstrapApp.php';



//executa os callbacks
Inoves_System::call($calls);


echo Inoves_View::show();


