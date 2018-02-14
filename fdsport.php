<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

require_once 'lib/core.php';

if (!isset($_SESSION)) {
	session_start();
}

// Application specific values
$nameApp = 'fdsport';
$defaultController = 'index';
$defaultMethod = 'index';

// Context initialisation
$context = context::getInstance();
$context->init($nameApp);

// Get controller, method and id from request URL
$request = (isset($_GET['request']) ? $_GET['request'] : ''); 
$request = explode('/', $request); 
 
$controller = (count($request) >= 1 ? $request[0] : $defaultController); 
$method = (count($request) >= 2 ? $request[1] : $defaultMethod); 
$id = (count($request) >= 3 ? $request[2] : false); 

require_once 'controller/' . $controller . '.php';

$controllerInst = new $controller();
$view = false;

if ($id) { 
    $view = $controllerInst->$method($id, $_REQUEST); 
} 
else { 
    $view = $controllerInst->$method($_REQUEST); 
}


/*
// Access control
if(key_exists("action", $_REQUEST) && $context->getSessionAttribute("user") !== null)
	$action =  $_REQUEST['action'];
*/

// Error handling
if($view === false){
	echo "Une grave erreur s'est produite, il est probable que l'action ".$action." n'existe pas...";
	die;
}

// Template
else {
	$viewContent = '/view/' . $view . '.php';
    include('/view/layout.php');
}

?>