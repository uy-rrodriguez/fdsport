<?php

require_once 'core/vendor/autoload.php';
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once 'core/context.class.php';
require_once 'core/dbconnection.class.php';

function autoloadClassModel($class)
{

    require_once 'model/'.$class.'.class.php';

}

spl_autoload_register('autoloadClassModel');

?>