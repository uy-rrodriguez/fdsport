<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

require_once 'lib/core.php';
require_once 'configuration/constants.php';

session_start();

// Context initialisation
$nameApp = 'fdsport';
$context = context::getInstance();
$context->init($nameApp);

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

require_once 'distance_matrix_api.php';

$city = getGeolocalizedCity();

$api = new DistanceMatrixApi();

$team = $api->findNearestTeam($city);

if ($team != null)
{

    $context->setSessionAttribute('team_geoloc', $team->name);

    $sport = sportTable::getSportById($team->id_sport);
    
    if ($sport != null)
    {
    
        $context->setSessionAttribute('sport_geoloc', $sport->name);
    
    }

}

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

// Create new Plates instance using the folder "view"
$plates = new League\Plates\Engine('view');

// Preassign data to the layout
//$plates->addData(['base_url' => 'http://localhost/fdsport']);

    
// Get controller, method and id from request URL
$request = (isset($_GET['request']) ? $_GET['request'] : '');
$request = explode('/', $request); 

$controller = (!empty($request[0]) ? $request[0] : 'index');
$method = (count($request) >= 2 ? $request[1] : 'index'); 
$id = (count($request) >= 3 ? $request[2] : false); 

require_once 'controller/' . $controller . '.php';

// Create new controller passing the Plates instance
$controllerClass = $controller . 'Ctrl';
$controllerInst = new $controllerClass($plates);

// Call corresponding controller method
if ($id !== false) {
    $controllerInst->$method($id);
}
else {
    $controllerInst->$method(); 
}


/*
// Access control
if(key_exists("action", $_REQUEST) && $context->getSessionAttribute("user") !== null)
	$action =  $_REQUEST['action'];
*/

/*
// Error handling
if($view === false){
	echo "Une grave erreur s'est produite, il est probable que l'action ".$action." n'existe pas...";
	die;
}

// Template
else {
	//$viewContent = '/view/' . $view . '.php';
    //include('/view/layout.php');
    
    // Render a template
    echo $templates->render($view);
}
*/

?>