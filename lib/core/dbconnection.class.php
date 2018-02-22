<?php
/*
define('HOST',	'pedago02a.univ-avignon.fr');
define('USER',	'uapv1604137');
define('PASS',	'GeVqo1');
define('DB',	    'etd');
*/

/*
define('HOST',	'ec2-54-247-81-88.eu-west-1.compute.amazonaws.com');
define('USER',	'pjuewlpereppdg');
define('PASS',	'440a9984e16b561078f84c4f97b5ba14c99c4dc5d30ceb12010fdb7fea0e0190');
define('DB',	'dai1mbra56rc92');
*/

$dbstr = getenv('DATABASE_URL');
var_dump($dbstr);

$dbstr = substr("$dbstr", 8);
$dbstrarruser = explode(":", $dbstr);
$dbstrarrhost = explode("@", $dbstrarruser[1]);
$dbstrarrrecon = explode("?", $dbstrarrhost[1]);
$dbstrarrport = explode("/", $dbstrarrrecon[0]);
$dbpassword = $dbstrarrhost[0];
$dbhost = $dbstrarrport[0];
$dbport = $dbstrarrport[0];
$dbuser = $dbstrarruser[0];
$dbname = $dbstrarrport[1];

define('HOST',	$dbhost);
define('USER',	$dbuser);
define('PASS',	$dbpassword);
define('DB',	$dbname);


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class dbconnection
{

	private static $instance = null, $entityManager;

	private $error = null;

	private function __construct()
	{

		$config = Setup::createAnnotationMetadataConfiguration(array("../../model/"), true);

		$param = array(
			'dbname'	=>	DB,
			'user'		=>	USER,
			'password'	=>	PASS,
			'host'		=>	HOST,
			'driver'	=>	'pdo_pgsql'
		);

		try
		{

			self::$entityManager = EntityManager::create($param, $config);

		}
		catch(Exception $e)
		{

			echo "Problème de connexion à la base de données : ".$e->getMessage();

			$this->error = $e->getMessage();

		}

	}

	public static function getInstance()
	{

		if(self::$instance == null)
		{

			self::$instance = new dbconnection();

		}

		return self::$instance;

	}

	public function closeConnection()
	{

		self::$instance = null;

	}

	public function getEntityManager()
	{

		if(!empty(self::$entityManager))
		{

			return self::$entityManager;

		}
		else
		{

			return null;

		}
			
	}

	public function __clone() {}

	public function getError()
	{

		return $this->error;

	}

}

?>