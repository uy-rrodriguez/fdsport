<?php
$request = (isset($_GET['request']) ? $_GET['request'] : '');
$request = explode('/', $request);

$module = (count($request) >= 1 ? $request[0] : false);
$method = (count($request) >= 2 ? $request[1] : false);
$id = (count($request) >= 3 ? $request[2] : false);

require_once 'controller/' . $module . '.php';
$controller = new $module();

if ($method) {
    if ($id) {
        $view = $controller->$method($id, $_GET);
    }
    else {
        $view = $controller->$method($_GET);
    }
}
else {
    $view = $controller->index($_GET);
}

require_once 'template/header.php';
require_once 'view/' . $view . '.php';
require_once 'template/footer.php';