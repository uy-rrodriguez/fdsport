<?php

define('HOST',	'pedago02a.univ-avignon.fr');
define('USER',	'uapv1604137');
define('PASS',	'GeVqo1');
define('DB',	'etd');

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